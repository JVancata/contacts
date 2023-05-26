FROM php:8.2-apache

RUN a2enmod rewrite

ENV MYSQL_USER="contacts"
ENV MYSQL_PASSWORD="contacts"
ENV MYSQL_DATABASE="contacts"
ENV PRODUCTION=true
ENV SESSION_TOKEN="secret-token"

COPY ./src /var/www/html/

RUN echo "<?php\ndefine('DATABASESERVER', 'localhost');\ndefine('DATABASENAME', '${MYSQL_DATABASE}');\ndefine('DATABASEUSER', '${MYSQL_USER}');\ndefine('DATABASEPASSWORD', '${MYSQL_PASSWORD}');\ndefine('PRODUCTION', true);\ndefine('SESSIONTOKEN', '${SESSION_TOKEN}');" > /var/www/html/config.php