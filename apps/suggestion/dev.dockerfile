FROM node:alpine As development

WORKDIR /usr/src/app


COPY pnpm-lock.yaml ./
COPY ./apps/suggestion/package.json package.json
COPY ./apps/suggestion/tsconfig.json tsconfig.json
COPY ./apps/suggestion/tsconfig.build.json tsconfig.build.json
COPY ./apps/suggestion/nest-cli.json nest-cli.json

RUN npm install -g pnpm

RUN pnpm install

COPY apps/suggestion apps/suggestion

RUN pnpm run build suggestion

FROM node:alpine as production

ARG NODE_ENV=production
ENV NODE_ENV=${NODE_ENV}

WORKDIR /usr/src/app

COPY package.json ./
COPY pnpm-lock.yaml ./

RUN npm install -g pnpm

RUN pnpm install --prod

COPY --from=development /usr/src/app/dist ./dist

CMD ["node", "dist/apps/suggestion/main"]
