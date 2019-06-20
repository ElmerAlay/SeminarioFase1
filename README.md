# SeminarioFase1
Fase 1 del proyecto de seminario
Seminario 1 - Proyecto 1 - Fase 1

# Prerequisito
-Instalar docker en la máquina
-Creamos una carpeta que contendrá todos nuestros dockerfile
	mkdir seminario1
-Nos movemos a esa carpeta
	cd seminario1/

# 1. MySQL
## 1.1. Creamos una carpeta llamada semi1-mysql
	mkdir mysql-microservice

## 1.2. Nos movemos a esa carpeta
	cd mysql-microservice/

## 1.3. Creamos un archivo llamado Dockerfile que contiene lo siguiente
     ## Pull the mysql:5.7 image
      FROM mysql:5.7

      ## The maintainer name and email
    MAINTAINER Elmer Alay <alayelmer1993@gmail.com>

      # database = test and password for root = password
      ENV MYSQL_DATABASE=test \
      MYSQL_ROOT_PASSWORD=1234

      # when container will be started, we'll have `test` database created with this schema
      COPY ./script.sql /docker-entrypoint-initdb.d/


## 1.4. Creamos el archivo script.sql con lo que se encuentra en la carpeta de mysql aquí
     en el repositorio.

## 1.5. Creamos un directorio de datos donde mysql guardará su contenido
	mkdir data

## 1.6. Dentro de nuestra carpeta creada semi1-mysql ejecutaremos el dockerfile
	docker build -t test-mysql .
     Semi-mysql es el nombre que escogí yo para la imagen

## 1.7. Con el siguiente comando podremos ver que nuestra imagen ya está creada
	docker images

## 1.8. Ahora crearemos el container con el siguiente código
	docker run  -d \
	--publish 6603:3306 \
	--volume=/~/seminario1/semi1-mysql/data:/var/lib/mysql \
	--name=test-mysql-microservice test-mysql

     -d comenzamos nuestro contenedor en modo detach 	
     --publish 6603:3306 indica que el puerto del servidor mysql será el 3306 y el puerto 6603 el host asignado
     También estamos utilizando nuestro directorio de almacenamiento de datos personalizado especificando el volumen de la ruta del     host. Aquí reemplazamos con la ruta de cada usuario.
     Por último nombramos nuestro container	    

## 1.9. Ahora ya podemos ver nuestro container levantado y funcionando
	docker ps

## 1.10. Con esto terminamos la parte de mysql.


# 2. Nodejs API
## 2.1 Regresamos a la carpeta creada inicialmente seminario1Fase1/

## 2.2 Creamos una nueva carpeta llamada semi1-nodejs
	mkdir nodejs-microservice

## 2.3 Nos movemos a esta carpeta
	cd nodejs-microservice/

## 2.4 Creamos el archivo Dockerfile y contendrá lo siguiente
    # Use Node v8 as the base image.
    FROM node:8

    # create and set app directory
    RUN mkdir -p /usr/src/app
    WORKDIR /usr/src/app

    # Install app dependencies
    # A wildcard is used to ensure both package.json AND package-lock.json are copied
    # where available (npm@5+)
    COPY package*.json ./
    RUN npm install

    # Copy app source from current host directory to container working directory
    COPY . .

    # Run app
    CMD ["npm", "start"]


## 2.5 Ahora creamos el archivo package.json y pegamos lo que se encuentra en la carpeta de nodejs
    dentro de este repositorio
	

## 2.6 Ahora creamos el archivo index.js y pegamos lo que se encuentra en la carpeta de nodejs
    dentro de este repositorio


## 2.7 Procedemos a construir la imagen con el docker file
	docker build -t test-nodejs .

## 2.8 Con el siguiente comando vemos las imagenes disponibles
	docker images

## 2.9 Ahora crearemos el container utilizando lo siguiente
docker run  -d \
--publish 4000:4000 \
-e MYSQL_USER='root' \
-e MYSQL_PASSWORD='1234' \
-e MYSQL_DATABASE='test' \
-e MYSQL_HOST='172.17.0.2' \
--link test-mysql-microservice:db \
--name=test-nodejs-microservice test-nodejs


## 2.10 Los parámetros utilizados son similares a los utilizados en el mysql. Colocamos ambos puertos como el 4000, indicamos nuestro usuario
     y contraseña de la base de datos. También colocamos el nombre de la bd y el host. Le indicamos desde que container nos vamos a conectar.
     Por último le damos nombre a nuestro nuevo container.

## 2.11 Ahora todo debería correr bien si colocamos el siguiente comando
	docker ps


## 2.12 Para comprobar que todo funciona probaremos las siguientes lineas de comandos y vermos el resultado

	curl --header "Content-Type: application/json" -d '{"rollNo": 2, "name": "Elmer alay"}' -X POST localhost:4000/add-student
	curl -X POST localhost:4000/get-students
	

# 3.  Servidor Web
Para el servidor web volvemos a nuestra carpeta inicial y creamos otra
	mkdir servidor-web

## 3.2 Nos movemos a la nueva carpeta
	cd servidor-web/

## 3.3 Creamos el docker file con lo siguiente
	FROM php:7.0-apache
	RUN apt-get update;
	COPY web /var/www/html
	EXPOSE 8080

## 3.4 Creamos un nuevo folder llamado web
	mkdir web

## 3.5 Nos movemos a el
	cd web/

## 3.6 Creamos la página web

## 3.7 regresamos a la carpeta del servidor-web
	cd ..

## 3.8 ejecutamos el dockerfile
	docker build -t test-php .

## 3.9 creamos el container
	docker run -it -p 8080:80 test-php

# Aclaración:
	Lamentablemente ya no pude mostrar los datos a través del servidor web porque no logré comunicarme con la base de datos. Sólo dejo una página de prueba.
	

