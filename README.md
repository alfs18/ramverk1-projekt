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

This will add the css-file mine4.css and some images in the img-folder:

`rsync -av vendor/alfs18/ramverk1-projekt/htdocs ./`


`rsync -av vendor/alfs18/ramverk1-projekt/sql ./`

`rsync -av vendor/alfs18/ramverk1-projekt/src ./`

`rsync -av vendor/alfs18/ramverk1-projekt/view ./`
