FROM wordpress:4.8.2-php7.0-apache

# Update aptitude with new repo and installing git + phpunit
RUN apt-get update && \
    apt-get -y install git && \
    apt-get -y install php5-mysql && \
    apt-get -y install wget && \
    apt-get -y install zip && \
    apt-get -y install unzip

# Get the latest version of phpunit
RUN wget http://phar.phpunit.de/phpunit.phar; \
    chmod +x phpunit.phar; \
    mv phpunit.phar /usr/bin/phpunit; 

# Move to WP directory
WORKDIR /var/www/html

# Pull the tests from github into non empty directory
COPY . /var/www/html

RUN mkdir -p /var/www/html/wp-content/themes/empty-theme

RUN ln -s /var/www/html/wp-content/themes/empty-theme /var/www/html/data/themedir1