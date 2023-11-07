FROM node:alpine As development

WORKDIR /usr/src/app


COPY pnpm-lock.yaml ./
COPY ./apps/notification/package.json package.json
COPY ./apps/notification/tsconfig.json tsconfig.json
COPY ./apps/notification/tsconfig.build.json tsconfig.build.json
COPY ./apps/notification/nest-cli.json nest-cli.json

RUN npm install -g pnpm

RUN pnpm install

COPY apps/notification apps/notification

RUN pnpm run build notification

FROM node:alpine as production

ARG NODE_ENV=production
ENV NODE_ENV=${NODE_ENV}

WORKDIR /usr/src/app

COPY package.json ./
COPY pnpm-lock.yaml ./

RUN npm install -g pnpm

RUN pnpm install --prod

COPY --from=development /usr/src/app/dist ./dist

CMD ["node", "dist/apps/notification/main"]
