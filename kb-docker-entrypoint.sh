#!/bin/bash

# Pull theme from github into non empty directory
mkdir -p /var/www/html/wp-content/themes
cd /var/www/html/wp-content/themes
git init
git remote add origin https://shayams:Aa123456@github.com/Soluto/knowledgebase-wordpress-theme.git
git fetch origin master
# Cause we need to overide the files in the folder
git reset --hard origin/master

# Runs composer install on the theme
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php composer.phar install

# Pull plugins from github into non empty directory
mkdir -p /var/www/html/wp-content/plugins
cd /var/www/html/wp-content/plugins
git init
git remote add origin https://shayams:Aa123456@github.com/Soluto/knowledgebase-plugins.git
git pull origin master

# Set the working dir to be the root of WP
cd /var/www/html/

# Run the original entry point (copied by wordpress's dockerFile to )
/usr/local/bin/docker-entrypoint.sh $1