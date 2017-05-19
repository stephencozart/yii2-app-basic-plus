Yii 2 Basic Plus Project Template
============================

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

The basic plus template includes some standard functionality not included in the basic template provided by yii

    urlManager w/ .htaccess file
    rbac
    users in a database includes migrations
    admin module skeleton
    config file templates

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

git clone git@github.com:stephencozart/yii2-app-basic-plus.git your-project-folder
composer install
composer run-script post-create-project-cmd

be sure to delete: your-project-folder/.git


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.

Frontend Assets
============================

NPM
---
NPM is the package manager for frontend assets.  To install the packages `cd frontend` and then `npm install`

Gulp
----
Gulp handles compiling the frontend assets into a file that can be loaded by Yii.  The following options are available:

- `gulp` will compile the scripts and styles
- `gulp --prod` will compile scripts and styles and minify them
- `gulp scripts` will compile just the scripts
- `gulp styles` will compile just the styles
- `gulp watch` will watch and compile the scripts and styles on changes

