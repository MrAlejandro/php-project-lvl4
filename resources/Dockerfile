FROM node:12.7.0-alpine

RUN apk update && \
    apk add --no-cache util-linux vim

RUN mkdir /app
WORKDIR /app

COPY ./package.json package.json
COPY ./package.lock package.lock

# ADD ../ /app

CMD npm install
