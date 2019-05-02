#!/bin/bash

cd ..
LIBRARY_PATH=$(pwd)/sherplay-h5p-library/H5P.Text

cd sherplay-h5p-plugin
DOCKER_COMPOSER=$(pwd)/docker-compose.yml

#
# Write docker-composer yml
#
cat <<EOF > $DOCKER_COMPOSER
version: '3'

services:
  sherplay-wordpress:
    image: wordpress
    ports:
      - 8081:80
    restart: always
    volumes:
      - .:/var/www/html/
      - ${LIBRARY_PATH}:/var/www/html/wp-content/uploads/h5p/libraries/H5P.Text-1.1
    environment:
      WORDPRESS_DB_HOST: mysql:3306
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpress
  mysql:
    image: mysql:5.7
    restart: always
    environment:
      MYSQL_USER: wordpress
      MYSQL_ROOT_PASSWORD: wordpress
      MYSQL_DATABASE: wordpress
      MYSQL_PASSWORD: wordpress
EOF

docker-compose up