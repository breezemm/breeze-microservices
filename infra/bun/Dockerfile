FROM oven/bun:latest as base
WORKDIR /usr/src/app

FROM base AS install
RUN mkdir -p /temp/dev
COPY package.json bun.lockb /temp/dev/

COPY apps/auth/package.json /temp/dev/apps/auth/
COPY apps/gateway/package.json /temp/dev/apps/gateway/
COPY apps/notifications/package.json /temp/dev/apps/notifications/
COPY apps/wallets/package.json /temp/dev/apps/wallets/

RUN cd /temp/dev && bun install --frozen-lockfile

