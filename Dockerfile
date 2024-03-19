# Use a imagem oficial do Ubuntu como base
FROM ubuntu:latest

# Atualize os pacotes do sistema
RUN apt-get update && \
    apt-get install -y software-properties-common

# Adicione o repositório para instalação do PHP 5.6
RUN add-apt-repository ppa:ondrej/php

# Adicione o repositório para instalação do Composer
RUN apt-get install -y curl

# Atualize novamente os pacotes do sistema após adicionar os repositórios
RUN apt-get update

# Instale o PHP 5.6 e os módulos necessários
RUN apt-get install -y php5.6 php5.6-cli php5.6-fpm php5.6-pgsql php5.6-mbstring php5.6-curl php5.6-json php5.6-gd php5.6-intl php5.6-xml php5.6-zip

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN sed -i 's/;extension=php_pgsql/extension=php_pgsql/' /etc/php/5.6/cli/php.ini

RUN sed -i 's/;extension=php_pdo_pgsql/extension=php_pdo_pgsql/' /etc/php/5.6/cli/php.ini
# Exemplo de comando para iniciar seu aplicativo PHP
CMD ["php", "-S", "0.0.0.0:8000"]
