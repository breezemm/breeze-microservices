# Breeze

The monorepo for the breeze microservices.

## Prerequisites

Before you begin, ensure you have met the following requirements:

| Windows        | Linux  | MacOS    |
|----------------|--------|----------|
| Docker Desktop | Docker | Orbstack |

## Endpoints

| Service Name         | Production           | Endpoint Development | Port  |
|----------------------|----------------------|----------------------|-------|
| API Gateway          | https://breezemm.com | 127.0.0.1            | 8001  |
| Wallet Service       |                      | 127.0.0.1            | 8002  |
| Notification Service |                      | 127.0.0.1            | 8003  |
| MySQL Database       |                      | 127.0.0.1            | 3306  |
| ZooKeeper            |                      | 127.0.0.1            | 2181  |
| Kafka                |                      | 127.0.0.1            | 29092 |
| Mailpit SMTP         |                      | 127.0.0.1            | 1025  |
| Mailpit Dashboard    |                      | 127.0.0.1            | 8025  |
| Redis                |                      | 127.0.0.1            | 6379  |

## MySQL Database Credentials

| Name      | Value        |
|-----------|--------------|
| User Name | root         |
| Password  | Not Required |

### Databases according to services

| Service Name          | Database Name |
|-----------------------|---------------|
| Gateway Service       | gateway       |
| Wallets Service       | wallets       |
| Notifications Service | notifications |

# Kafka

## Development

You can use [kaf](https://github.com/birdayz/kaf) to interact with the kafka cluster.

Alternatively you can use the following service to create the topics.

```yaml
  init-kafka:
      image: confluentinc/cp-kafka:7.5.1
      depends_on:
          - kafka
      entrypoint: [ '/bin/sh', '-c' ]
      command: |
          "
          # blocks until kafka is reachable
          kafka-topics --bootstrap-server kafka:29092 --list

          echo -e '🙌 Creating kafka topics'
          kafka-topics --bootstrap-server kafka:29092 --create --if-not-exists --topic wallets --replication-factor 1 --partitions 3
          kafka-topics --bootstrap-server kafka:29092 --create --if-not-exists --topic notifications --replication-factor 1 --partitions 3

          echo -e '🐙 Successfully created the following topics:'
          kafka-topics --bootstrap-server kafka:29092 --list
          "
      networks:
          - dev
```

# Object Storage

## Development

We are using Minio as the storage service for development. You can use the following docker-compose file to start the
minio service.

```yaml
  minio:
      image: 'minio/minio:latest'
      ports:
          - '${FORWARD_MINIO_PORT:-9000}:9000'
          - '${FORWARD_MINIO_CONSOLE_PORT:-8900}:8900'
      environment:
          MINIO_ROOT_USER: root
          MINIO_ROOT_PASSWORD: password
      volumes:
          - 'minio:/data/minio'
      networks:
          - dev
      command: 'minio server /data/minio --console-address ":8900"'
      healthcheck:
          test: [ "CMD", "curl", "-f", "http://localhost:9000/minio/health/live" ]
          retries: 3
          timeout: 5s
```

Below is the mino service configuration in the `docker-compose.yml` file.
You have to start the minio service first to create the bucket. The create-bucket service will create the bucket and set
the permissions for the bucket and then exit.

```yaml

create-bucket:
    image: minio/mc:latest
    depends_on:
        - minio
    entrypoint: [ "/bin/sh", "-c" ]
    command: |
        "
        # set host alias
        mc alias set minio http://minio:9000 root password

        # create IAM user
        # ref: https://min.io/docs/minio/linux/administration/identity-access-management/minio-user-management.html#id5
        mc admin user add minio access_key secret_key
        mc admin policy attach minio readwrite --user=access_key

        # create bucket
        mc mb minio/breeze
        mc anonymous set upload minio/breeze
        mc anonymous set download minio/breeze
        mc anonymous set public minio/breeze
        exit 0;
        "
    networks:
        - dev
```

### Configuration for Minio

```dotenv
# Minio
FILESYSTEM_DRIVER=s3
MEDIA_DISK=s3

AWS_ACCESS_KEY_ID=access_key
AWS_SECRET_ACCESS_KEY=secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=breeze
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_ENDPOINT=http://minio:9000
AWS_URL="http://localhost:9000/${AWS_BUCKET}"
```

## Production

We are using AWS S3 as the storage service for production. You can use the following configuration to set up the S3
service.

```dotenv
MEDIA_DISK=s3
FILESYSTEM_DISK=s3

 AWS S3
AWS_ACCESS_KEY_ID="AKIA2UC3ARFJW73XFMFC"
AWS_SECRET_ACCESS_KEY="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"
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=breeze-staging-storage
AWS_ENDPOINT="https://s3.${AWS_DEFAULT_REGION}.amazonaws.com/${AWS_BUCKET}"
```
