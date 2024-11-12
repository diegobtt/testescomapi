import './App.css'
import React, { useState, useEffect } from 'react';
import axios from 'axios';

function App() {
  const [data, setData] = useState(null);

  useEffect(() => {
    axios.get('http://localhost:57000')
      .then((response) => {
        setData(response.data);
      })
      .catch((error) => {
        console.error("Erro ao fazer a requisição:", error);
      });
  }, []); 

  return (
    <div>
      <h1>Dados recebidos do servidor:</h1>
      
      {data ? (
        <pre>{JSON.stringify(data, null, 2)}</pre>
      ) : (
        <p>Carregando...</p>
      )}
    </div>
  );
}

export default App
