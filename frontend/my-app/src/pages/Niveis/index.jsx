import React, { useEffect, useState } from 'react';
import { api } from '../../utils/api';
import { Link, useNavigate } from 'react-router-dom';
import { FormularioNivel } from '../../components/FormularioNivel';
import { Modal } from '../../components/Modal';

export function Niveis({ niveis, programadores }) {
    const [modalIsOpen, setModalNivelIsOpen] = useState(false);
    const [modalDetalhesIsOpen, setModalDetalhesOpen] = useState(false);
    const [programadoresNivel, setProgramadoresNivel] = useState([]);
    const [quantidadeProgramadores, setQuantidadeProgramadores] = useState(0);
    const navigate = useNavigate();

    function handleClickButton() {
        openModal();
    }

    function handleDetalhesClick(nivelId) {
        const programadoresDoNivel = programadores.filter(
            (programador) => programador.nivel === nivelId
        );
        setProgramadoresNivel(programadoresDoNivel);
        setQuantidadeProgramadores(programadoresDoNivel.length);
        openModalDetalhes();
    }

    function openModal() {
        setModalNivelIsOpen(true);
    }

    function closeModal() {
        setModalNivelIsOpen(false);
        navigate('/');
    }

    function openModalDetalhes() {
        setModalDetalhesOpen(true);
    }

    function handleCloseModalDetalhes() {
        setModalDetalhesOpen(false);
    }

    return (
        <>
            <div className="quadrados-container">
                {niveis.map((nivel) => (
                    <div
                        key={nivel.id}
                        className="quadrado"
                        style={{
                            backgroundColor: '#3d3f95',
                            color: 'white',
                            textAlign: 'center',
                            padding: '60px',
                            fontSize: '20px',
                            borderRadius: '8px',
                            margin: '10px',
                        }}
                    >
                        {nivel.nivel}
                        <button
                            className="quadrado-button"
                            onClick={() => handleDetalhesClick(nivel.id)}
                        >
                            Detalhes
                        </button>
                        <Link to={'/editar_nivel/' + nivel.id}>Editar</Link>
                        <Link to={'/deletar_nivel/' + nivel.id}>Deletar</Link>
                    </div>
                ))}
            </div>

            <FormularioNivel closeModal={closeModal} modalIsOpen={modalIsOpen} />

            <button onClick={handleClickButton}>Adicionar Nível</button>

            {modalDetalhesIsOpen && (
                <Modal visible={modalDetalhesIsOpen} onClose={handleCloseModalDetalhes}>
                    <h2>Programadores do Nível</h2>
                    <p>Quantidade total de programadores: {quantidadeProgramadores}</p>
                    <ul>
                        {programadoresNivel.map((programador) => (
                            <li key={programador.id}>{programador.nome}</li>
                        ))}
                    </ul>
                </Modal>
            )}
        </>
    );
}
