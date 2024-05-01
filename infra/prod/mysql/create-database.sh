#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
  CREATE DATABASE IF NOT EXISTS gateway;
  GRANT ALL PRIVILEGES ON \`gateway%\`.* TO '$MYSQL_USER'@'%';

  CREATE DATABASE IF NOT EXISTS notifications;
  GRANT ALL PRIVILEGES ON \`notifications%\`.* TO '$MYSQL_USER'@'%';

  CREATE DATABASE IF NOT EXISTS wallets;
  GRANT ALL PRIVILEGES ON \`wallets%\`.* TO '$MYSQL_USER'@'%';
EOSQL
