FROM node:21-alpine

WORKDIR /var/www/notification

COPY package.json .

RUN npm install -g npm@latest
RUN npm install -g pnpm
RUN pnpm install

COPY . .

RUN pnpm run build

CMD ["pnpm", "run", "start"]