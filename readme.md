# Knowledgebase test
This repo uses docker to run wordpress insance with phpunit inside.
2 main reasone to use this repo are:
1. Run phpunit tests for our wordpress environment (can also be used without docker).
2. Run a local instance of wordpress for development.
## How to run PHPUnit tests
### Without Docker

1. Clone this repository
2. Copy all the content to the root folder of the website (`wp-test-includes` should be a sibling of `wp-includes`)
3. Modify the following values in wp-tests-config.php so that they are identical to the values in wp-config.php:
    1. DB_NAME
    2. DB_USER
    3. DB_PASSWORD
    4. DB_HOST
4. For Windows only: add to the system PATH the following value: `c:\xampplite\php`
5. In case you have the folder mu-plugins under wp-content, move all of its content to a different folder
6. Open command line/terminal/bash. Go to the website root folder and run PHPUnit

### With Docker
1. Clone this repository
2. Run `docker-compose up -d` from the folder you cloned the repo to
3. Run `docker-compose exec wordpress phpunit`

## How to run wordpress instance for development
1. Create a new directory that will contain the 3 repositories. In the next steps we will call this directory the _root_ (e.g. `/home/projects/wordpress-dev`)
If you want to change the structure of the directories, make sure to map the paths in `knowledgebase-tests/docker-compose.override.yml`
2. Clone this repository under the _root_ directory (i.e. `_root_/knowledgebase-tests`)
3. Login to Soluto's dockerhub using `docker login`
4. Clone the [theme repository](https://github.com/Soluto/knowledgebase-wordpress-theme) under the _root_ folder (i.e. `_root_/knowledgebase-wordpress-theme`)
5. Create a folder named `wordpress-docker-data` under the _root_ folder  
This folder will function as a "view" to the wordpress folder in the container. You will be able to edit and open wp files from it (for ex the debug file)
6. Install and run [composer](https://getcomposer.org/download/):
    * MacOS/Linux:
        - Go to the themes folder
        - `wget https://getcomposer.org/composer.phar` or `curl -O https://getcomposer.org/composer.phar`
        - `php composer.phar install`
    * On windows you can install composer globally and run `composer install` from the theme's folder
7. Run `npm install` form the theme's folder
    * If you don't have composer globally installed, you will get `sh: composer: command not found`. Just run `php composer.phar install` again from the previous step.
8. Run `gulp build` from the theme's folder
    * If you don't have gulp globally installed, run `node node_modules/gulp-cli/bin/gulp.js build`
9. Clone the [plugin repository](https://github.com/Soluto/knowledgebase-plugins) under the _root_ folder (i.e. `_root_/knowledgebase-plugins`)
10. Run `docker-compose up -d` from `_root_/knowledgebase-tests`
    * For Windows Only:
        * On the first run of docker-compose, you should get a pop-up asking permissions to share drive C:. If it doesn't show, rerun docker-compose.
        * Then, you'll get another pop-up window where you need to type your local credentials (your Soluto username and password)  
11. You are done! - you can now open http://localhost:8000/ to configure your wordpress instance.
12. Activate our theme:
    - Click Appearance -> Themes
    - Click Activate on "Empty Theme"
13. Copy from production the relevant plugins:
    * Advanced Custom Fields Pro
    * CPT UI
    * << OTHERS? >>
You can download the plugins with sftp from WP Engine (`kbsolutonew-youyousername@kbsolutonew.sftp.wpengine.com:2222/wp-content/plugins`). You will need to create staging/production users from the [WP Engine](https://my.wpengine.com/installs/kbsolutonew/sftp_users) website.
14. Activate the desired plugins
15. Import post status definitions from production:
    * In https://kb.mysoluto.com/wp-admin: Custom Fields -> Tools -> Toggle All -> Download Export File
    * In https://localhost:8000/wp-admin: Custom Fields -> Tools -> Choose File -> Import
    
16. Import CPT UI definitions from prod/staging
17. Import Menu Editor Pro definitions from prod/staging (important: click Save Changes after import)
18. Import Symptoms Library: Tools -> Export -> Symptoms Library -> click Download Export File, and then Import in the local env
19. To enable Languages, and generation of Topic IDs:

- Go to Languages -> Languages, and verify the English is the default language (marked with a star on the languages table)

- Go to Languages -> Settings -> Custom post types and Taxonomies -> Settings, and check *all* post types except: `Alerts`, `Multi Article | Steps` and `Symptoms Library`. Then, click "Save Changes"

20. Change permalink settings as follows:

- Go to Settings -> Permalinks

- Choose `Custom Structure` and in the text box fill in `/%post_id%`.

- Save changes

21. To enable debug logs:
    * Go to the `wordpress-docker-data` folder and open `wp-config.php` for editing
    * Replace 
    ```php
    define('WP_DEBUG', false);
    ``` 
    with   
      ```php
      define('WP_DEBUG', true);
      define('WP_DEBUG_DISPLAY', true );  
      define('WP_DEBUG_LOG', true );
      ```


## How to add tests to the theme

1. Add appropriate subfolder to `/path/to/website/wp-content/themes/empty-theme/tests`. 
  * Path should reflect the structure of the tested code. e.g. the test functions of `empty-theme/components/feedback` will be placed under `empty-theme/tests/components/feedback`
2. File name should start with "test-" and end with ".php".
3. Copy structure and use example from `/path/to/website/wp-content/themes/empty-theme/tests/components/some_component/test-some-component.php`

### Q&A (Troubleshooting)

Q: Why does my wp-json endpint does not work
A: According to [this](https://developer.wordpress.org/rest-api/extending-the-rest-api/routes-and-endpoints/) you need to enable [pretty permalinks](https://codex.wordpress.org/Introduction_to_Blogging#Pretty_Permalinks) so the wp-json endpoint will work.  
Just go to the permalink in the settings, Select the 'Custom Structure' and put '/%post_id%'
