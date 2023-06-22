# Use a imagem base do Node.js
FROM node:20-alpine

# Defina o diretório de trabalho dentro do container
WORKDIR /app

# Copie o arquivo package.json e package-lock.json (ou yarn.lock) para o diretório de trabalho
COPY package*.json ./

# Instale as dependências do projeto
RUN npm install

# Copie todo o código fonte do projeto para o diretório de trabalho
COPY . .

# Inicie a aplicação quando o container for executado
CMD ["npm", "start"]