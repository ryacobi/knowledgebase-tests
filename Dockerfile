FROM wordpress:latest

# Update aptitude with new repo and installing git + phpunit
RUN apt-get update && \
    apt-get -y install git-all && \
    apt-get -y install phpunit

# Move to WP directory
WORKDIR /var/www/html

# Pull the tests from github into non empty directory
COPY . /var/www/html

#RUN git init
#RUN git remote add origin https://shayams:Aa123456@github.com/Soluto/knowledgebase-unit-tests.git
#RUN git pull origin master