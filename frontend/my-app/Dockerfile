FROM node:18-alpine as build

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . /app/

RUN npm run build


# Estágio de produção
FROM nginx:latest as production-stage

COPY --from=build /app/build /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]