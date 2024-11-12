FROM node:20-alpine

WORKDIR /app

COPY package*.json ./my_app

RUN npm install

COPY ./my_app .

RUN npm run build

RUN npm install -g serve

CMD ["serve", "-s", "dist", "-l", "3000"]

EXPOSE 3000
