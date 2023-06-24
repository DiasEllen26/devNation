
#  DevNation

Esta é uma API RESTful desenvolvida em Laravel para gerenciar níveis e programadores, juntamente com uma interface de usuário React para interação com a API. A API utiliza os métodos GET, POST, PUT/PATCH e DELETE para manipulação dos recursos. A documentação da API é fornecida usando o Swagger.

## Recursos

### Níveis

- **Listar níveis existentes**
  - Método: GET
  - Endpoint: `/niveis`
  - Respostas:
    - 200 OK: Retorna a lista de níveis existentes.
    - 404 Not Found: Caso não haja nenhum nível encontrado.

- **Cadastrar um nível**
  - Método: POST
  - Endpoint: `/niveis`
  - Corpo da requisição: JSON com os dados do nível a ser cadastrado.
  - Respostas:
    - 201 Created: Nível cadastrado com sucesso.
    - 400 Bad Request: Erro de validação nos dados do nível.

- **Editar um nível**
  - Método: PUT
  - Endpoint: `/nivel/{id}`
  - Parâmetro: ID do nível a ser editado.
  - Corpo da requisição: JSON com os dados atualizados do nível.
  - Respostas:
    - 200 OK: Nível editado com sucesso.
    - 400 Bad Request: Erro de validação nos dados do nível.
    - 404 Not Found: Nível não encontrado.

- **Remover um nível**
  - Método: DELETE
  - Endpoint: `/nivel/{id}`
  - Parâmetro: ID do nível a ser removido.
  - Respostas:
    - 204 No Content: Nível removido com sucesso.
    - 400 Bad Request: Erro ao remover o nível.
    - 404 Not Found: Nível não encontrado.
    - 501 Not Implemented: Não é possível remover um nível quando há programadores associados a ele.

### programadores

- **Listar programadores existentes**
  - Método: GET
  - Endpoint: `/programadores`
  - Respostas:
    - 200 OK: Retorna a lista de programadores existentes.
    - 404 Not Found: Caso não haja nenhum programador encontrado.

- **Cadastrar um programador**
  - Método: POST
  - Endpoint: `/programadores`
  - Corpo da requisição: JSON com os dados do programador a ser cadastrado.
  - Respostas:
    - 201 Created: programador cadastrado com sucesso.
    - 400 Bad Request: Erro de validação nos dados do programador.

- **Editar um programador**
  - Método: PUT/PATCH
  - Endpoint: `/programador/{id}`
  - Parâmetro: ID do programador a ser editado.
  - Corpo da requisição: JSON com os dados atualizados do programador.
  - Respostas:
    - 200 OK: programador editado com sucesso.
    - 400 Bad Request: Erro de validação nos dados do programador.
    - 404 Not Found: programador não encontrado.

- **Remover um programador**
  - Método: DELETE
  - Endpoint: `/programador/{id}`
 

 - Parâmetro: ID do programador a ser removido.
  - Respostas:
    - 204 No Content: programador removido com sucesso.
    - 400 Bad Request: Erro ao remover o programador.
    - 404 Not Found: programador não encontrado.

## Funcionalidades Adicionais

- **Busca de níveis por query string**
  - Método: GET
  - Endpoint: `/niveis?search={nomedonivel}`
  - Parâmetro: Termo de busca para filtrar os níveis.
  - Respostas:
    - 200 OK: Retorna a lista de níveis que correspondem ao termo de busca.
    - 404 Not Found: Caso não haja nenhum nível encontrado.

- **Busca de programadores por query string**
  - Método: GET
  - Endpoint: `/programadores?search={nomedoprogramador}`
  - Parâmetro: Termo de busca para filtrar os programadores.
  - Respostas:
    - 200 OK: Retorna a lista de programadores que correspondem ao termo de busca.
    - 404 Not Found: Caso não haja nenhum programador encontrado.

- **Tratamento de Exceções / Retornos de erros concisos**
  - A API possui tratamento de exceções e retorna mensagens de erro concisas e informativas.

- **Paginação na listagem de níveis e programadores**
  - Os endpoints `/niveis` e `/programadores` suportam paginação para exibir os resultados em partes.

- **Retorno visual de mensagens de sucesso e erros**
  - A interface do usuário React exibe notificações visuais para mensagens de sucesso e erros com o Sweet Alert.

- **Retorno visual para confirmação da remoção de itens do CRUD**
  - A interface do usuário React exibe uma confirmação visual de antes de remover um nível ou programador.

- **Ordenação dos campos em forma crescente/decrescente**
  - A interface do usuário React permite ordenar os campos selecionando o título da tabela de listagem.

- **Validações de campos dos formulários**
  - A API realiza validações nos campos dos formulários para garantir dados consistentes.

- **Exibição da quantidade de programadores associados a um nível**
  - No botão "Detalhes" que fica nos Nivel, aparece os programadores que estão relacionados a ele.

## Configuração e Execução

Siga as instruções abaixo para configurar e executar a API e a interface de usuário:

### Requisitos
- Laravel 
- Xamp/Mamp/Wamp
- Docker
- Docker Compose

### Passos

1. Clone o repositório para sua máquina local.
```
git clone https://github.com/DiasEllen26/devnation.git
```

2. Acesse o diretório do projeto.
```
cd devnation
```

3. Acesse o diretorio da API
```
cd backend
```
4. No xamp/mamp/wampp inicie o mysql e apache
5. Faça uma cópia do arquivo `.env.example` e renomeie para `.env`:
   ```
   cp .env.example .env
   ```

6. Execute o seguinte comando para gerar uma nova chave de aplicativo:
   ```
   php artisan key:generate
   ```

7. Execute o seguinte comando para criar as tabelas do banco de dados:
   ```
   php artisan migrate
   ```

8. O projeto Laravel está pronto para ser executado. Inicie o servidor da web localmente executando o seguinte comando:
   ```
   php artisan serve
   ```
7. Acesse a da API em seu navegador em [http://localhost:8000](http://localhost:8000).

8. Acesse a documentação da API Swagger em seu navegador em [http://localhost:8000/api/documentacao](http://localhost:8000/api/documentation).

### Acessando o Container React no Diretório `frontend`

Após configurar e executar a API no contêiner Docker, você pode configurar e executar o aplicativo React no contêiner separado. Siga os passos abaixo para acessar o contêiner do frontend e iniciar o aplicativo React:

1. Certifique-se de ter concluído os passos anteriores para iniciar os contêineres Docker e garantir que a API Laravel esteja em execução.

2. Abra um novo terminal.

3. Acesse o diretório do projeto `devnation` novamente, caso já não esteja nele:


1. Abra um novo terminal.

2. Certifique-se de estar no diretório raiz do projeto `devnation`.

3. Acesse o diretório do frontend:
   ```
   cd frontend
   ```

4. Execute o seguinte comando para instalar as dependências do React:
   ```
   npm install
   ```

5. Após a instalação das dependências, inicie o servidor de desenvolvimento do React:
   ```
   docker-compose up -d
   ```

6. Agora, você pode acessar o aplicativo React no navegador em [http://localhost:3000](http://localhost:3000).

Certifique-se de que os contêineres da API e do frontend estejam em execução simultaneamente para que o aplicativo React possa consumir a API corretamente. Certifique-se também de que as portas `8000` e `3000` estejam disponíveis em sua máquina local.

Dessa forma, você terá a API RESTful em execução no contêiner Docker e o aplicativo React consumindo essa API em um contêiner separado.

Agora você pode interagir com a API por meio da interface de usuário React e consultar a documentação em Swagger para obter detalhes sobre os endpoints e suas respostas.

## Considerações Finais

Este projeto oferece uma API completa para gerenciamento de níveis e programadores, juntamente com uma interface de usuário intuitiva para facilitar a interação. O uso do Laravel como backendm React como frontend e Docker para facilitar o ambiente de desenvolvimento torna a configuração e execução do projeto simples e eficiente.
