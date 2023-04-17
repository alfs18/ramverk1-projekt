[![Maintainability](https://api.codeclimate.com/v1/badges/9b229ffd9fce8eb3ace0/maintainability)](https://codeclimate.com/github/alfs18/ramverk1-projekt/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/9b229ffd9fce8eb3ace0/test_coverage)](https://codeclimate.com/github/alfs18/ramverk1-projekt/test_coverage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alfs18/ramverk1-projekt/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/alfs18/ramverk1-projekt/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/alfs18/ramverk1-projekt/badges/build.png?b=main)](https://scrutinizer-ci.com/g/alfs18/ramverk1-projekt/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/alfs18/ramverk1-projekt/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

Install the module
===================

Step one to install the module:

`composer require alfs18/ramverk1-projekt`

Then, to get the files, type:

**Please note** that the following line will overwrite your header.php and responsive.php.

`rsync -av vendor/alfs18/ramverk1-projekt/config ./`

or (if you don't want to overwrite header.php and responsive.php):

`rsync -av vendor/alfs18/ramverk1-projekt/config/router ./config`


`rsync -av vendor/alfs18/ramverk1-projekt/content/block/picture.md ./content/block`

The following line will add the css-file mine4.css and some images in the img-folder.

`rsync -av vendor/alfs18/ramverk1-projekt/htdocs ./`


`rsync -av vendor/alfs18/ramverk1-projekt/sql ./`

`rsync -av vendor/alfs18/ramverk1-projekt/src ./`

`rsync -av vendor/alfs18/ramverk1-projekt/view ./`


Add the tables to the database db.sqlite
---------
`sqlite3 data/db.sqlite < sql/ddl/answer_comments_sqlite.sql`

`sqlite3 data/db.sqlite < sql/ddl/answers_sqlite.sql`

`sqlite3 data/db.sqlite < sql/ddl/comments_sqlite.sql`

`sqlite3 data/db.sqlite < sql/ddl/pictures_sqlite.sql`

`sqlite3 data/db.sqlite < sql/ddl/question_sqlite.sql`

`sqlite3 data/db.sqlite < sql/ddl/user_sqlite.sql`
