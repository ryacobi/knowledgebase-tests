#!/bin/bash

# Pull theme from github into non empty directory
mkdir -p /var/www/html/wp-content/themes
cd /var/www/html/wp-content/themes
git init
git remote add origin https://shayams:Aa123456@github.com/Soluto/knowledgebase-wordpress-theme.git
git fetch origin master
# Cause we need to overide the files in the folder
git reset --hard origin/master

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

phpunit