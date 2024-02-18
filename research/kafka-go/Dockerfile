# Choose whatever you want, version >= 1.16
FROM golang:1.21-alpine

WORKDIR /app

RUN go install github.com/cosmtrek/air@latest

COPY ./apps/kafka-go/go.mod ./apps/kafka-go/go.sum ./
RUN go mod download

CMD ["air", "-c", ".air.toml"]
