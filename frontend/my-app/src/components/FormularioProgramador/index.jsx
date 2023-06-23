import React, { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { Modal } from '../../components/Modal';
import { useForm, setValue } from 'react-hook-form'
import Swal from 'sweetalert2';
import { yupResolver } from '@hookform/resolvers/yup';
import { api } from '../../utils/api';
import * as yup from "yup";
import './style.css'

export function FormularioProgramador({ closeModal, modalIsOpen, niveis }) {
    const [valueProgramador, setValueProgramador] = useState({
        nome: "",
        idade: "",
        sexo: "",
        datanascimento: "",
        nivel: "",
        hobby: "",
    });
    const [niveisRequest, setNiveisRequest] = useState([]);
    const [title, setTitle] = useState("Cadastrar programador")
    const [url, setUrl] = useState("/programador")
    const [modalProgramadorIsOpen, setModalProgramadorOpen] = useState(true);

    const { id } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        setModalProgramadorOpen(modalIsOpen)
    }, [modalIsOpen])


    useEffect(() => {
        if (id) {
            setTitle("Editar Programador");
            setUrl(`/programadores/${id}`)
            setModalProgramadorOpen(true)
            Promise.all([
                api.get(`/programadores/${id}`),
                api.get('/niveis'),
            ])
                .then(([programadoresResponse, nivelRsponse]) => {
                    setValueProgramador(programadoresResponse.data);
                    setNiveisRequest(nivelRsponse.data.data);
                })
                .catch((error) => {
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

    function closeModalProgramador() {
        setModalProgramadorOpen(false)
        navigate('/')
    }


    const validationPost = yup.object({
        nome: yup.string()
            .required("Campo nome é obrigatório")
            .max(255, "Campo não pode ter mais que 255 caracteres!"),
        idade: yup.number()
            .transform((value) => (isNaN(value) || value === null || value === undefined) ? 0 : value)
            .required("Campo idade não pode estar vazio!")
            .max(120, "Idade máxima aceita, 120 anos")
            .test("Numeros negativos", "Não pode inserir numeros negativos!", value => {
                return value && value > 0
            }),
        sexo: yup.string()
            .required("Campo sexo não pode ser vazio")
            .max(255, "Campo não pode ter mais que 255 caracteres!"),
        datanascimento: yup.mixed()
            .required("Campo data não pode ser vazio")
            .test(
                'valid-date',
                'Formato de data inválido. Por favor, insira uma data válida.',
                function (value) {
                    // Verifica se o valor é uma data válida
                    return yup.date().isValidSync(value);
                }
            )
            .transform((value, originalValue) => {
                if (originalValue) {
                    const date = new Date(originalValue);
                    const year = date.getFullYear();
                    const month = `0${date.getMonth() + 1}`.slice(-2);
                    const day = `0${date.getDate()}`.slice(-2);

                    // Formata a data para o formato desejado (yyyy-MM-dd)
                    return `${year}-${month}-${day}`;
                }
                return value;
            }),
        nivel: yup.number()
            .transform((value) => Number(value))
            .required("Campo nivel não pode ser vazio!"),
        hobby: yup.string()
            .required("Campo hobby é obrigatorio")
            .max(255, 'Campo não pode ter mais que 255 caracteres!'),
    })

    const { register, handleSubmit, formState: { errors } } = useForm({
        resolver: yupResolver(validationPost)
    })

    const updateProgrammer = data => api.put(url, data)
        .then((response) => {
            closeModalProgramador()
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
            closeModalProgramador()

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

    const registerProgrammer = data => api.post(url, data)
        .then((response) => {
            closeModalProgramador()

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
            closeModalProgramador()

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
                visible={modalProgramadorIsOpen}
                onClose={id ? closeModalProgramador : closeModal}
                title={title}
            >
                <form className="form-container" onSubmit={handleSubmit(id ? updateProgrammer : registerProgrammer)}>
                    <div className="form-group">
                        <label htmlFor="nome" className="form-label">
                            Nome:
                        </label>
                        <input
                            type="text"
                            id="nome"
                            defaultValue={valueProgramador.nome}
                            name='nome'
                            {...register('nome')}
                            className="form-input"

                        />
                        <p className='error-message'>{errors.nome?.message}</p>
                    </div>
                    <div className="form-group">
                        <label htmlFor="sexo" className="form-label">
                            Nível:
                        </label>
                        <select
                            id="nivel"
                            name='nivel'
                            {...register('nivel')}
                            className="form-input"
                            defaultValue={valueProgramador.nivel}
                        >
                            {niveis ? niveis.map(item => (
                                <option key={item.id} value={item.id}>{item.nivel}</option>
                            )) : niveisRequest.map(item => (
                                <option key={item.id} value={item.id}>{item.nivel}</option>
                            ))}


                        </select>
                        <p className='error-message'>{errors.nivel?.message}</p>
                    </div>
                    <div className="form-group">
                        <label htmlFor="sexo" className="form-label">
                            Sexo:
                        </label>
                        <select
                            id="sexo"
                            name='sexo'
                            {...register('sexo')}
                            className="form-input"
                            defaultValue={valueProgramador.sexo}
                        >
                            <option value="">Selecione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                        <p className='error-message'>{errors.sexo?.message}</p>
                    </div>

                    <div className="form-group">
                        <label htmlFor="dataNascimento" className="form-label">
                            Data de Nascimento:
                        </label>
                        <input
                            type="date"
                            id="dataNascimento"
                            name='datanascimento'
                            {...register('datanascimento')}
                            className="form-input"
                            defaultValue={valueProgramador.datanascimento}
                        />
                        <p className='error-message'>{errors.datanascimento?.message}</p>
                    </div>
                    <div className="form-group">
                        <label htmlFor="idade" className="form-label">
                            Idade:
                        </label>
                        <input
                            type="number"
                            id="idade"
                            name='idade'
                            {...register('idade')}
                            className="form-input"
                            defaultValue={valueProgramador.idade}
                        />
                        <p className='error-message'>{errors.idade?.message}</p>
                    </div>
                    <div className="form-group">
                        <label htmlFor="hobby" className="form-label">
                            Hobby:
                        </label>
                        <input
                            type="text"
                            id="hobby"
                            name='hobby'
                            {...register('hobby')}
                            className="form-input"
                            defaultValue={valueProgramador.hobby}
                        />
                        <p className='error-message'>{errors.hobby?.message}</p>
                    </div>
                    <button type="submit" className="form-button">
                        Enviar
                    </button>
                </form>
            </Modal>

        </>
    )
}