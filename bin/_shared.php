<?php
/**
 * @file
 * This is a shared file for the 
 */

require_once FORT_APP_PATH . '/vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use Fortissimo\CLI\Runtime\Runner;
use Fortissimo\Registry;

global $argv;

// We are expecting this to run in the form of:
//   php app.php command --options
// If a different format is going to be used this next section should be modified.
// From the example above $argv[0] is app.php and $argv[1] is command.
if (count($argv) < 2) {
  print "You must specify a target. Try 'help'." . PHP_EOL;
  exit(1);
}

// We are expecting the command as the first thing following the name of the app.
$target = $argv[1];

$argvOffset = 1;


// Build the registry. The name of the registry should be changed to a name for
// the application.
$registry = new Registry('fort-application');

// The output injection logger puts any log messages into the buffer. Think of
// this like using print or echo.
$registry->logger('\Fortissimo\Logger\OutputInjectionLogger', 'foil');


// Load all of the configuration files. They are loaded in alpha order.
$iterator = Finder::create()->files()->name('*.php')->in(array(FORT_APP_PATH . '/config'));
$config = iterator_to_array($iterator);
foreach ($config as $file) {
  require_once $file;
};


// Run the commandline runner.
$runner = new Runner($argv);
$runner->useRegistry($registry);

try {
  $runner->run($target);
}
catch (\Exception $e) {
  printf("Error: %s\n", $e->getMessage());
}
