<?php
/**
 * @file
 * Master configuration file. This should be included first.
 */
global $registry, $argv, $argvOffset;

$registry->route('test', 'A test command and writes test output.')
  ->does('\Fortissimo\CLI\IO\WriteLine')
    ->using('output')->from('cxt:output')
    ->using('text', 'This is a test.')
  ;

$registry->route('help', "Show the help text")
  ->does('\Fortissimo\Command\CLI\ShowHelp');
