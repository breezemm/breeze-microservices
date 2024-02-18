#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS gateway;
    GRANT ALL PRIVILEGES ON \`gateway%\`.* TO '$MYSQL_USER'@'%';

    CREATE DATABASE IF NOT EXISTS notification;
    GRANT ALL PRIVILEGES ON \`notification%\`.* TO '$MYSQL_USER'@'%';

    CREATE DATABASE IF NOT EXISTS wallet;
    GRANT ALL PRIVILEGES ON \`wallet%\`.* TO '$MYSQL_USER'@'%';
EOSQL