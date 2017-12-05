FROM wordpress:4.8.2-php7.0-apache

# Update aptitude with new repo and installing git + phpunit
RUN apt-get update && \
    apt-get -y install git && \
    apt-get -y install phpunit && \
    apt-get -y install php5-mysql

# Move to WP directory
WORKDIR /var/www/html

# Pull the tests from github into non empty directory
COPY . /var/www/html
