About `silex-bootstrap`
=======================

This repository provides a starting point for building Silex applications. It
includes:

- A directory structure
- Stubs and default configuration
- CI/QA config

To start a new project, run:

    composer create-project --repository-url="git@github.com:aptoma/silex-bootstrap.git" <target>

You should answer `yes` to remove version control files, and are then free to
do whatever you want. This repo contains a few example files and comments like
this one, that should obviously not remain within the project.

By design, this bootstrap should include more than you are likely to need,
as it's easier to delete stuff, than to add.

If you find yourself changing a lot of stuff, ask why you do those changes, and
if maybe not they should be part of the default setup of this repo. No projects
are equal, so some variance in how to do stuff is of course expected.

To get started, you probably want to have a look at `app/app.php` to see the
config bootstrap, and then have a look `app/routing.php`,
`src/App/Controller/DefaultController.php` and `src/App/views` for some basic
actions.

When ready, delete everything in this section, and upgrade the following sections
according to your project.

TODO:

- Set up default deployment routines (using Capistrano)
- Provide a better starting point for JS/CSS
- Provide cache headers management for assets
- Iterate

Project Name
============

Tech Lead: name <email@aptoma.com>

Describe project

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

Set up paths for logging and caching:

	$ grunt mac-paths --user="_www"

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
extracting them to separate packages that can be managed by Composer.
