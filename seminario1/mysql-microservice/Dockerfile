## Pull the mysql:5.7 image
FROM mysql:5.7

## The maintainer name and email
MAINTAINER Elmer Alay <alayelmer1993@gmail.com>

# database = test and password for root = password
ENV MYSQL_DATABASE=test \
    MYSQL_ROOT_PASSWORD=1234

# when container will be started, we'll have `test` database created with this schema
COPY ./script.sql /docker-entrypoint-initdb.d/
