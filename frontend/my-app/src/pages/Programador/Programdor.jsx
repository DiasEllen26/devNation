import React, { useEffect, useState } from 'react';
import { api } from '../../utils/api';
import { Link, useNavigate } from 'react-router-dom';
import { FormularioProgramador } from '../../components/FormularioProgramador';

export function Programadores({ programadores, niveis }) {
    const [modalIsOpen, setModalIsOpen] = useState(false);
    const navigate = useNavigate();

    function handleClickButton() {
        openModal()
    }

    function openModal() {
        setModalIsOpen(true)
    }
    function closeModal() {
        setModalIsOpen(false)
        navigate('/')
    }
    return (
        <>
            <div className="quadrados-container">
                {programadores.map((programador) => (
                    <div
                        key={programador.id}
                        className='quadrado'
                        style={{
                            backgroundColor: '#3d3f95',
                            color: 'white',
                            textAlign: 'center',
                            padding: '60px',
                            fontSize: '20px',
                            borderRadius: '8px',
                            margin: '10px'
                        }}
                    >
                        <h3><strong>{programador.nome}</strong></h3>
                        <p>{programador.nivel.nivel}</p>
                        <p>É {programador.sexo}</p>
                        <p>Nascido em {programador.datanascimento}</p>
                        <p>Tem {programador.idade} Anos</p>
                        <p>Gosta de:  {programador.hobby}</p>

                        <Link to={"/editar_programador/" + programador.id} >Editar</Link>
                        <Link to={"/deletar_programador/" + programador.id} >Deletar</Link>
                    </div>
                ))}
            </div>
            <br />
            <br />

            <FormularioProgramador closeModal={closeModal} modalIsOpen={modalIsOpen} niveis={niveis} />

            <button onClick={handleClickButton}>Adicionar Programador</button>
        </>
    )


}