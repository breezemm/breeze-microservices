FROM node:lts-alpine3.19 as builder

WORKDIR /var/www/suggestion

COPY package.json .
COPY tsconfig.json .
COPY tsconfig.build.json .
COPY nest-cli.json .

RUN npm install -g pnpm
RUN pnpm install

COPY . .
RUN pnpm run build suggestion


FROM node:lts-alpine3.19

WORKDIR /var/www/suggestion

RUN npm install -g pnpm

COPY . .
COPY --from=builder /var/www/suggestion/node_modules ./node_modules
COPY --from=builder /var/www/suggestion/dist ./dist

CMD ["node", "dist/apps/suggestion/main"]