#!/bin/bash
echo "yes"
# Pull theme from github into non empty directory
cd /var/www/html/wp-content/themes
git init
git remote add origin https://shayams:Aa123456@github.com/Soluto/knowledgebase-wordpress-theme.git
git fetch origin master
# Cause we need to overide the files in the folder
git reset --hard origin/master

# Pull plugins from github into non empty directory
cd /var/www/html/wp-content/plugins
git init
git remote add origin https://shayams:Aa123456@github.com/Soluto/knowledgebase-plugins.git
git pull origin master

# Run the original entry point (copied by wordpress's dockerFile to )
sh docker-entrypoint.sh