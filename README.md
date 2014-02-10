Silex Bootstrap
===============

This repository provides a starting point for building Silex applications. It
includes:

- A directory structure
- Stubs and default configuration
- CI/QA config

This repo is complemented by [aptoma/silex-extras](https://github.com/aptoma/silex-extras),
which contains various helpers, base classes and services. The idea is that you will never
need to do a rebase of Silex Bootstrap, as all significant updates will be handled by Silex
Extras, which you can simply update through Composer. In fact, you should delete the `.git`
directory after downloading the project.

To start a new project, run:

    $ composer create-project aptoma/silex-bootstrap <target-dir>

To get started, you probably want to have a look at `app/app.php` to see the
config bootstrap, and then have a look `app/routing.php`,
`src/App/Controller/DefaultController.php` and `src/App/views` for some basic
actions.

This repo contains a few example files and comments like this one, that should
obviously not remain within the project. When ready, delete everything in this
section, and update the following sections according to your project.

Project Name
============

Tech Lead: name <email@aptoma.com>

## Product Description

### Purpose

A clearly defined and documented purpose and lifetime

### Technologies

A description of technologies and components/modules

### Integration with other company products

A description of other company products in use/integrated with

### External Dependencies

A description of external dependencies (both people and systems)

### Roadmap

Roadmap and maintenance plan


## Folder Outline

    app     # Config and bootstrap
    src     # Application code and views
    tests   # All tests
    web     # Public doc root. Front controller and assets.

During installation and CI these folders may also be created:

    build        # Reports from various build tasks
    node_modules # Dependencies managed by npm
    vendor       # Dependencies managed by Composer

By default, logs and cache is written to `app/log` and `app/cache` respectively.

## Installation

Describe how to install


## Development

Install dependencies (requires [Composer](https://getcomposer.org/download),
[NPM](https://github.com/joyent/node/wiki/Installing-Node.js-via-package-
manager) and [Bundler](http://gembundler.com/) to be installed globally)

    $ composer --dev install
    $ npm install
    $ bundle install

You also need to install jshint and grunt-cli globally:

    $ npm install -g jshint@0.9.1
    $ npm install -g grunt-cli@0.1.6

Set up paths for logging and caching:

    $ grunt mac-paths
    # OR if your web server doesn't run as the default _www
    $ grunt exec:mac-paths:<web_server_user>

To watch your project, run `bundle exec guard`;

### Permissions

For local development, you need to setup cache and log dirs:

    mkdir -p app/cache
    mkdir -p app/log

These directories must be writable both by the web server and the command line user.
On a UNIX system, if your web server user is different from your command line user,
you can run the following commands just once in your project to ensure that permissions
will be setup properly. Change www-data to your web server user:

#### 1. Using ACL on a system that supports chmod +a (Typically MAC OS X)

Many systems allow you to use the chmod +a command. Try this first, and if you get an error - try the next method:

    $ sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" app/cache app/log
    $ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/log

#### 2. Using Acl on a system that does not support chmod +a (Typically Ubuntu)

Some systems don't support chmod +a, but do support another utility called setfacl.
You may need to [enable ACL support](https://help.ubuntu.com/community/FilePermissionsACLs)
on your partition and install setfacl before using it (as is the case with Ubuntu), like so:

    $ sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
    $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs


Describe other stuff needed for local development

## Testing

PHP Tests are powered by PHPUnit. You have several options.

- Run `phpunit` if PHPUnit is installed globally.
- Run `bin/vendor/phpunit` to run version installed by Composer. This ensures
  that you are running a version compatible with the test suite.
- Run `grunt phpunit`, basically just a wrapper for `bin/vendor/phpunit`
- Run `bundle exec guard` to watch files and run tests when source or test files
  change

JavaScript testing is under development.

## Contributing

Describe guidelines for contributing.

To contribute to _this_ project, simply create a feature branch, do your thing,
and open a pull request. If you do lot's of stuff in your project that you think
should be easily backported to older `silex-bootstrap` based projects, consider
extracting them to separate packages that can be managed by Composer, or add them to
[silex-extras](https://github.com/aptoma/silex-extras).
