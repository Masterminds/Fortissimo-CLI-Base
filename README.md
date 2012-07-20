# Fortissimo CLI Base
This is a skeleton project for building CLI applications using [PHP](http://php.net), [Fortissimo](http://github.com/Masterminds/Fortissimo), and [Composer](http://getcomposer.org).

Fortissimo is a chain-of-command based framework. This means you create reusable configurable parts called command containing some logic. Each callback (in the case of a CLI application we have CLI commands) executes a chain of these commands. Different callbacks can share commands. Yeah, I know this is a little abstract. More real world examples coming soon.

## Using the Skeleton
There are two ways you get started using this skeleton project. The simplest is to use `composer create-project` in a manner like:

    > composer create-project Masterminds/Fortissimo-CLI-Base foo-project-name

This will get you right up and going. Alternately you can grab this project right out of git. Then from the root of the project run `composer install` to install all the project dependencies. You should also update the `composer.json` file to include any dependencies of your own and add your psr-0 config component for autoloading.

## The Project Structure
This project is structured so you can hit the ground running. The usage expectation is the following:

### The src directory
This is where all your custom code should go. Ideally it would be placed in here using a PSR-0 layout and the root composer.json file would be updated for this so you can use the composer autoloader.

### The test directory
This is where tests for your code should go. Test driven development is a great practice, right?!?!

### The bin directory
This directory contains a number of important files to get you right up and going.

* _compile.php_ - This file is a Phar compiler. It takes the application here and compiles it into a Phar file so you can distribute this as one file. If you open this file and edit it you'll see a number of configurable options such as the name of the file, what files and folders to include, etc.
* *_shared.php* - This file is the application script. This is shared between the Phar and non-Phar execution version. This is the file to update for the application. Out of the box this file should be about ready to use for most applications.
* _app.php_ - This is the application execution script in a non-Phar form. This is what should be called in testing, etc. It sets up the environment for the file system before calling *_shared.php*.
* *_phar.php* - This the Phar stub that works in a similar manner to *app.php*. The difference is this file sets up the environment for a Phar file before calling *_shared.php*.

For most applications only the *_shared.php* and *compile.php* files will need to be altered here and in most cases just for the custom name of the application.

### The config directory
I tend to think of the chain-of-command pattern like piping in PHP. Something like Yahoo Pipes but coded in PHP. This is where the chains are configured.

When the application bootstraps it includes each of the PHP files in this directory in alphabetical order to load the config options. The initial file 000-init.php is named so it is included first. This does some initial setup.

In files in this directory you write chains of commands. More detail and some examples coming soon.

## Compiling A Phar
Who wants a CLI application that's really a bunch of files and you have to call to some internal file? Not me. I prefer things with nice simple names and one file I can distribute. PHP Phar files let us do this as they can contain an entire project in a single file.

To execute these Phar files you'll need PHP and any dependencies on your operating system. Working on a Mac, everything I need is already bundled and available on that system.

Once you are ready to convert you application into a single file open up `bin/compile.php` so that it contains the name and proper location for your application. Then execute this file with `php bin/compile.php` and it will generate a Phar file for you.

Like composer these files can be run with php in fort of them or as self executing files.

_Naming note: I often see phar files have the extension .phar. This is optional. You can create phar files with no extension and all. This along with self execution means you could write a CLI app like `AwesomeSauce` and just call that from the CLI. How you do this is entirely up to you. I'm just saying there are options._

## License
This project is licensed under the MIT License.