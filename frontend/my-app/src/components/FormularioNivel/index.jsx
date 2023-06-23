import React, { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { Modal } from '../../components/Modal';
import { useForm, setValue } from 'react-hook-form'
import Swal from 'sweetalert2';
import { yupResolver } from '@hookform/resolvers/yup';
import { api } from '../../utils/api';
import * as yup from "yup";
import './style.css'

export function FormularioNivel({ closeModal, modalIsOpen }) {

    const [valueNivel, setValueNivel] = useState({})
    const [title, setTitle] = useState("Cadastrar nivel")
    const [url, setUrl] = useState("/nivel")
    const [modalNivelIsOpen, setModalNivelOpen] = useState(modalIsOpen);


    const { id } = useParams();
    const navigate = useNavigate();

    const validationPost = yup.object({
        nivel: yup.string()
            .required("Campo nivel é obrigatório")
            .max(255, "Campo não pode ter mais que 255 caracteres!"),
    })

    const { register, handleSubmit, formState: { errors } } = useForm({
        resolver: yupResolver(validationPost)
    })

    useEffect(() => {
        setModalNivelOpen(modalIsOpen)
    }, [modalIsOpen])

    useEffect(() => {
        if (id) {
            setTitle("Editar Nivel");
            setUrl(`/niveis/${id}`)
            setModalNivelOpen(true)
            api.get(`/niveis/${id}`)
                .then((response) => {
                    setValueNivel(response.data)
                })
                .catch((error) => {
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Opa algo deu errado!',
                        text: error,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            navigate('/');
                        }
                    });
                });
        }
    }, [id]);


    function closeModalNivel() {
        setModalNivelOpen(false)
        navigate('/')
    }



    const updateNivel = data => api.put(url, data)
        .then((response) => {
            closeModalNivel()
            Swal.fire(
                'Sucesso!',
                response.data.message,
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    navigate('/');
                }
            });
        })
        .catch((response) => {
            closeModalNivel()
            const errorResponse = response.response.data;
            const errors = Object.values(errorResponse.error);
            const errorMenssage = errors.reduce((mensageFinal, error) => {
                return mensageFinal + error
            }, "");


            Swal.fire({
                icon: 'error',
                title: 'Opa algo deu errado!',
                text: errorMenssage,
            }).then((result) => {
                if (result.isConfirmed) {
                    navigate('/');
                }
            });
        })

    const registerNivel = data => api.post(url, data)
        .then((response) => {
            closeModalNivel()
            console.log(response.data)
            Swal.fire(
                'Sucesso!',
                response.data.message,
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    navigate('/');
                }
            });
        })
        .catch((response) => {
            console.log(response)
            closeModalNivel()
            const errorResponse = response.response.data;
            const errors = Object.values(errorResponse.error);
            const errorMenssage = errors.reduce((mensageFinal, error) => {
                return mensageFinal + error
            }, "");

            Swal.fire({
                icon: 'error',
                title: 'Opa algo deu errado!',
                text: errorMenssage,
            }).then((result) => {
                if (result.isConfirmed) {
                    navigate('/');
                }
            });
        })

    return (
        <>
            <Modal
                visible={modalNivelIsOpen}
                onClose={id ? closeModalNivel : closeModal}
                title={title}
            >
                <form className="form-container" onSubmit={handleSubmit(id ? updateNivel : registerNivel)}>
                    <div className="form-group">
                        <label htmlFor="nome" className="form-label">
                            Nivel:
                        </label>
                        <input
                            type="text"
                            id="nivel"
                            defaultValue={valueNivel.nivel}
                            name='nivel'
                            {...register('nivel')}
                            className="form-input"

                        />
                        <p className='error-message'>{errors.nome?.message}</p>
                    </div>
                    <button type="submit" className="form-button">
                        Enviar
                    </button>
                </form>
            </Modal>

        </>
    )
}