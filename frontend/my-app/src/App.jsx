import React, { useEffect, useState } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faBars } from '@fortawesome/free-solid-svg-icons';
import './App.css';
import niveisBanner from './img/niveis2.png';
import programadoresBanner from './img/programadores2.png';
import logo from './img/logo1.png'
import { api } from './utils/api';
import Swal from 'sweetalert2';
import { Niveis } from './pages/Niveis';
import { Programadores } from './pages/Programador/Programdor';
import { Loading } from './components/loading';
import { Link, useNavigate } from 'react-router-dom';
import { Modal } from './components/Modal';

function App() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [programadores, setProgramadores] = useState([]);
  const [niveis, setNiveis] = useState([]);
  const [isLoading, setLoading] = useState(true);

  const [inputSearchValue, setInputSerachValue] = useState('');
  const [programadorSerach, setProgramadorSearch] = useState([]);
  const [modalSerachIsOpen, setModalSearchOpen] = useState(false)

  const navigate = useNavigate();

  const toggleMenu = () => {
    setMenuOpen(!menuOpen);
  };


  useEffect(() => {
    Promise.all([api.get('/programadores'), api.get('/niveis')])
      .then(([programadoresResponse, niveisResponse]) => {
        setProgramadores(programadoresResponse.data);
        setNiveis(niveisResponse.data.data);
        setLoading(false);
      })
      .catch((error) => {
        Swal.fire({
          icon: 'error',
          title: 'Opa, algo deu errado!',
          text: error,
        });
      });
  }, []);


  useEffect(() => {
    if (inputSearchValue.lenght > 2) {
      setModalSearchOpen(true)
      api.get(`/programadores?search=${inputSearchValue}`)
        .then((response) => {
          setProgramadorSearch(response.data)
          console.log(response.data)
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
        })
    } else {
      handleCloseModalSerach()
      setProgramadorSearch([])
    }

    console.log(programadorSerach)
    console.log(inputSearchValue)
  }, [inputSearchValue])

  function handleInputChange(event) {
    setInputSerachValue(event.target.value);
  };

  function handleCloseModalSerach() {
    setModalSearchOpen(false)
  }

  return (
    <div>
      {isLoading ? (
        <Loading />
      ) : (
        <div className="App">
          <nav className="navbar">
            <div className="navbar-left">
              <img src={logo} alt="DevNation" className="logo" />
            </div>
            <div className="navbar-center">
              <ul className="menu-desktop">
                <li className="menu-item">Níveis</li>
                <li className="menu-item">Programadores</li>
              </ul>
            </div>
            <div className="navbar-right">
              <input type="text" placeholder="Buscar" value={inputSearchValue} onChange={handleInputChange} className="search-input" />
            </div>
            <div className={`menu-icon ${menuOpen ? 'active' : ''}`} onClick={toggleMenu}>
              <FontAwesomeIcon icon={faBars} />
            </div>
            {menuOpen && (
              <div className="menu-mobile">
                <input type="text" placeholder="Buscar" value={inputSearchValue} onChange={handleInputChange} className="search-input" />
                <ul className="menu-items">
                  <li className="menu-item">Níveis</li>
                  <li className="menu-item">Programadores</li>
                </ul>
              </div>
            )}
          </nav>
          <div className="content">
            <div>
              <img className="img-niveis" src={niveisBanner} alt="Descrição do Banner" style={{ maxWidth: '100%', height: '100%' }} />
              <Niveis niveis={niveis} programadores={programadores} />
            </div>
            <div>
              <img className="img-niveis" src={programadoresBanner} alt="Descrição do Banner" style={{ maxWidth: '100%', height: '100%' }} />
              <Programadores programadores={programadores} niveis={niveis} />
            </div>
          </div>
        </div>
      )}

      {
        (
          <Modal
            visible={modalSerachIsOpen}
            onClose={handleCloseModalSerach}
          >
            <div className="quadrados-container">
              {programadorSerach.map((programador) => (
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
          </Modal>

        )
      }

    </div>

  );
}

export default App;
