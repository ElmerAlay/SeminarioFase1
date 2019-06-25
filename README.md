# SeminarioFase1
Fase 1 del proyecto de seminario
Seminario 1 - Proyecto 1 - Fase 1

# Prerequisito
	-Instalar docker en la máquina
	-Creamos una carpeta que contendrá todos nuestros dockerfile
	-mkdir seminario1
	-Nos movemos a esa carpeta
	cd seminario1/

# 1. MySQL
## 1.1. Creamos una carpeta llamada mysql-microservice
	mkdir mysql-microservice

## 1.2. Nos movemos a esa carpeta
	cd mysql-microservice/

## 1.3. Creamos un archivo llamado Dockerfile que contiene lo siguiente
	FROM mysql:5.7
	MAINTAINER Elmer Alay <alayelmer1993@gmail.com>

	ENV MYSQL_DATABASE=seminario1 \
	MYSQL_ROOT_PASSWORD=1234
	COPY ./script.sql /docker-entrypoint-initdb.d/

## 1.4. Creamos el archivo script.sql y copiamos lo que se encuentra en la carpeta de mysql aquí en este repositorio.

## 1.5. Creamos un directorio de datos donde mysql guardará su contenido, en este caso se llamará data
	mkdir data

## 1.6. Dentro de nuestra carpeta creada semi1-mysql ejecutaremos el dockerfile
	docker build -t test-mysql .
     	
	test-mysql es el nombre que escogí para la imagen

## 1.7. Con el siguiente comando podremos ver que nuestra imagen ya está creada
	docker images

## 1.8. Ahora crearemos el container con el siguiente código
	docker run  -d \
	--publish 6603:3306 \
	--volume=/~/seminario1/mysql-microservice/data:/var/lib/mysql \
	--name=test-mysql-microservice test-mysql

   -d comenzamos nuestro contenedor en modo detach 	
   --publish 6603:3306 indica que el puerto del servidor mysql será el 3306 y el puerto 6603 el host asignado
   También estamos utilizando nuestro directorio de almacenamiento de datos personalizado especificando el volumen de la ruta del        	host. Aquí reemplazamos con la ruta de cada usuario.
     	Por último nombramos nuestro container	    

## 1.9. Ahora ya podemos ver nuestro container levantado y funcionando
	docker ps

## 1.10. Con esto terminamos la parte de mysql.


# 2. Nodejs API
## 2.1 Regresamos a la carpeta creada inicialmente seminario1/

## 2.2 Creamos una nueva carpeta llamada nodejs-microservice
	mkdir nodejs-microservice

## 2.3 Nos movemos a esta carpeta
	cd nodejs-microservice/

## 2.4 Creamos un archivo llamado Dockerfile y escribimos lo siguiente
    	FROM node:8

	RUN mkdir -p /usr/src/app
	WORKDIR /usr/src/app

	COPY package*.json ./
	RUN npm install

	COPY . .

	CMD ["npm", "start"]

## 2.5 Ahora creamos un archivo llamado package.json y pegamos lo que se encuentra en el archivo del mismo nombre dentro de la carpeta de nodejs de este repositorio
	
## 2.6 Ahora creamos un archivo llamado index.js y pegamos lo que se encuentra en el archivo del mismo nombre dentro de la carpeta de nodejs de este repositorio

## 2.7 Procedemos a construir la imagen con el docker file
	docker build -t test-nodejs .

## 2.8 Con el siguiente comando vemos las imagenes disponibles
	docker images

## 2.9 Ahora crearemos el container utilizando lo siguiente
	docker run  -d \
	--publish 4000:4000 \
	-e MYSQL_USER='root' \
	-e MYSQL_PASSWORD='1234' \
	-e MYSQL_DATABASE='seminario1' \
	-e MYSQL_HOST='172.17.0.2' \
	--link test-mysql-microservice:db \
	--name=test-nodejs-microservice test-nodejs

## 2.10 Los parámetros utilizados son similares a los utilizados en el mysql. Colocamos ambos puertos como el 4000, indicamos nuestro usuario y contraseña de la base de datos. También colocamos el nombre de la bd y el host. Le indicamos desde que container nos vamos a conectar. Por último le damos nombre a nuestro nuevo container.

## 2.11 Ahora todo debería correr bien si colocamos el siguiente comando
	docker ps

## 2.12 Para comprobar que todo funciona probaremos las siguientes lineas de comandos y vermos el resultado
	curl --header "Content-Type: application/json" -d '{"idproducto": 21, "nombre": "ProductoB"}' -X POST localhost:4000/agregar
	curl -X POST localhost:4000/productos

# 3.  Servidor Web
## 3.1 Para el servidor web volvemos a nuestra carpeta inicial de seminario1/ y creamos otra
	mkdir webserver-microservice

## 3.2 Nos movemos a la nueva carpeta
	cd webserver-microservice/

## 3.3 Creamos un archivo llamado Dockerfile con lo siguiente
	FROM php:7.0-apache
	RUN apt-get update;
	COPY web /var/www/html
	EXPOSE 8080

## 3.4 Creamos un nuevo folder llamado web dentro de la carpeta webserver-microservice/
	mkdir web

## 3.5 Nos movemos a el
	cd web/

## 3.6 Creamos un archivo llamado index.php y colocamos lo que está en el archivo del mismo nombre dentro de la carpeta servidor-web dentro de este repositorio

## 3.7 regresamos a la carpeta del servidor-web
	cd ..

## 3.8 ejecutamos el dockerfile
	docker build -t test-web .

## 3.9 creamos el container
	docker run -it -p 8080:80 test-web

# 4 Acceder a la web
Ahora podemos ingresar por medio de la ip pública de nuestra máquina seguido del puerto 8080 y podremos ver los datos almacenados en la base de datos.
	

