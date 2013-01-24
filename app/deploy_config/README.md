Deploy Config
=============

This folder should contain any config that is specific to various deploys.
Typically, every customer will have certain custom settings, like API urls,
and maybe feature flags.

During deploy, the customer file will be copied to `app/config.php`.

You can create your own `app/config.php` to tweak settings for your local
environment. This file is ignored by git.
