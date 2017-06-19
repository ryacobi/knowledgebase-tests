FROM wordpress:4.8-php5.6-apache

# Update aptitude with new repo and installing git + phpunit
RUN apt-get update && \
    apt-get -y install git && \
    apt-get -y install phpunit

# Move to WP directory
WORKDIR /var/www/html

# Pull the tests from github into non empty directory
COPY . /var/www/html
COPY kb-docker-entrypoint.sh /usr/local/bin/

RUN chmod 777 /usr/local/bin/kb-docker-entrypoint.sh

ENTRYPOINT kb-docker-entrypoint.sh apache2-foreground

#RUN git init
#RUN git remote add origin https://shayams:Aa123456@github.com/Soluto/knowledgebase-unit-tests.git
#RUN git pull origin master