import React, { useState } from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import { FormularioProgramador } from './components/FormularioProgramador';
import { DeletarProgramador } from './components/DeletarProgramador';
import { FormularioNivel } from './components/FormularioNivel';
import { DeletarNivel } from './components/DeletarNivel';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<App />} />
      <Route path="/editar_programador/:id" element={<FormularioProgramador />} />
      <Route path="/editar_nivel/:id" element={<FormularioNivel />} />
      <Route path="/deletar_programador/:id" element={<DeletarProgramador />} />
      <Route path="/deletar_nivel/:id" element={<DeletarNivel />} />
    </Routes>
  </BrowserRouter>


);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
