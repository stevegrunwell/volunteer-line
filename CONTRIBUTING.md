# Contributing to Volunteer Line

Thank you for taking an interest in contributing to the development of Volunteer Line!

## Installation

For local development, the easiest way to get started is via [Laravel Homestead](https://laravel.com/docs/master/homestead), the official [Vagrant](https://www.vagrantup.com/) box for Laravel development.

The Homestead virtual machine contains all of the necessary tools for building and running the application. To get started, begin by cloning this Git repository onto your local machine, then run the following commands:

```sh
# Install Composer dependencies.
$ composer install

# Prepare the repository for Laravel Homestead.
$ composer homestead

# Provision the Vagrant VM.
$ vagrant up

# Finally, SSH into the Vagrant box to work with the app:
$ vagrant ssh
```

### Applying personal customizations to Homestead

If you want to apply customizations to the Homestead environment (such as setting the default editor or any additional aliases), you may do so by adding a `user-customizations.sh` file to the root of the project.

This file **will not** be committed to the repository, and is only for setting personal preferences.

[More on the `user-customizations.sh` file can be found in this blog post](https://stevegrunwell.com/blog/laravel-homestead-user-customizations-sh/).

## Coding standards

The application is written using the [PSR-2 coding standards](https://www.php-fig.org/psr/psr-2/), which is the current recommendation of the PHP Framework Interoperability Group (PHP-FIG).

## Automated testing

This project features several types of automated testing, based upon [PHPUnit](https://phpunit.de/).

All of these tests will be run — and expected to pass — as part of the project's Continuous Integration (CI) pipeline.

### Unit and Integration tests

The application's Unit and Integration (a.k.a. "Feature") tests are written using [Laravel's default test appliances](https://laravel.com/docs/master/testing).

These tests can be run at any time by running:

```
$ vendor/bin/phpunit
```

### Code coverage

This project aims to have percentage of code coverage via automated tests. That being said, 100% code coverage is not always reasonable, and it's better to have coverage below 100% than have a codebase with large chunks omitted from coverage reports.
