<?php
/**
 * @file
 * A simple cli tool to build a phar file for this project.
 */
use Fortissimo\CLI\Phar\Compiler;
use Fortissimo\CLI\IO\BasicOutput;

define('FORT_APP_PATH', dirname(__DIR__));
require_once FORT_APP_PATH . '/vendor/autoload.php';

/**
 * Below this line is config settings for this application. Defaults and
 * documentation provided.
 */

// The path and name of the file to generate.
$pharFile = FORT_APP_PATH . '/app.phar';

// The internal name for the Phar builder.
$name = 'demo_app';

// An array of files to include in the Phar.
$files = array(
  FORT_APP_PATH . '/bin/_shared.php',
  FORT_APP_PATH . '/vendor/autoload.php'
);

// An array of directories to traverse and include the files from.
$directories = array(
  FORT_APP_PATH . '/vendor',
  FORT_APP_PATH . '/src',
  FORT_APP_PATH . '/config'
);

// The path to the stub file.
$stub_file = FORT_APP_PATH .'/bin/_phar.php';

// The name pattern to search for within directories.
$name_pattern = '*.php';

// The base path to the project with no trailing /.
$base_path = FORT_APP_PATH;

/**
 * Below this line is the builder.
 */
// @todo Update this to happen in a try/catch sequence with some error handling.
$compiler = new Compiler();
$compiler->compile($pharFile, $name, $files, $directories, $stub_file, $base_path, $name_pattern);

// Notify the user the phar has been created.
$output = new BasicOutput();
$output->writeln("<info>The file {$pharFile} has been generated.</info>");
