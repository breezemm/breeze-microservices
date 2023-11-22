# Laravel with MongoDB in Mac

## Install MongoDB

```sh
brew install icu4c #install unicode library
brew link icu4c --force
```

## Install PHP MongoDB Driver

```sh
export PATH="/usr/local/opt/icu4c/bin:$PATH"
export PATH="/usr/local/opt/icu4c/sbin:$PATH"
export LDFLAGS="-L/usr/local/opt/icu4c/lib"
export CPPFLAGS="-I/usr/local/opt/icu4c/include"

sudo pecl install mongodb
```

## Add extension to php.ini

Add the following lines to your php.ini file

```ini
extension = rdkafka.so
extension = mongodb.so
```
