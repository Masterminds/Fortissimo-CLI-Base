<?php
/**
 * @file
 * This is a shared file for the 
 */

require_once FORT_APP_PATH . '/vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\Adapter\PhpAdapter;
use Fortissimo\CLI\Runtime\Runner;
use Fortissimo\Registry;
use Fortissimo\CLI\IO\BasicOutput;
use Fortissimo\CLI\IO\BasicPrompt;

global $argv;

$target = \Fortissimo\CLI\ParseOptions::getFirstArgument($argv);

if (empty($target)) {
  $target = 'help';
}

// Build the registry. The name of the registry should be changed to a name for
// the application.
$registry = new Registry('fort-application');

// Adding prompts (input) and output.
$output = new BasicOutput();
$prompt = new BasicPrompt($output);
$registry->datasource(function() use ($output) {return $output; }, 'output');
$registry->datasource(function() use ($prompt) {return $prompt; }, 'prompt');

// The output injection logger puts any log messages into the buffer. Think of
// this like using print or echo.
$registry->logger('\Fortissimo\Logger\OutputInjectionLogger', 'foil');


// Load all of the configuration files. They are loaded in alpha order.
$iterator = Finder::create()->files()->name('*.php')->in(array(FORT_APP_PATH . '/config'));

// Because this iterator may be used in a Phar file we want to specify the PhpAdapter.
// @todo When moving to symfony version greater than 2.1.x uncomment the following 2 lines.
//$iterator->removeAdapters();
//$iterator->addAdapter(new PhpAdapter());
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
