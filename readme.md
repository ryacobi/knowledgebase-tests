How to run PHPUnit on your local environment
============================================

1. clone this repository to some folder
2. copy all the content to the root folder of the website (wp-test-includes should be a sibling of wp-includes)
3. Modify the following values in wp-tests-config.php so that they are identical to the values in wp-config.php:
    1. DB_NAME
    2. DB_USER
    3. DB_PASSWORD
    4. DB_HOST
4. For Windows only: add to the system PATH the following value: c:\xampplite\php
5. Open command line/terminal/bash. Go to the website root folder and run PHPUnit


How to add tests to the theme
=============================

1. Add appropriate subfolder to /path/to/website/wp-content/themes/empty-theme/tests. 
  * Path should reflect the structure of the tested code. e.g. the test functions of empty-theme/components/feedback will be placed under empty-theme/tests/components/feedback
2. File name should start with "test-" and end with ".php".
3. Copy structure and use example from /path/to/website/wp-content/themes/empty-theme/tests/components/some_component/test-some-component.php
