##Installation/Setup of Behat and PhpUnit

Behat
 + run ``composer install``
 + edit <project-root>/behat.yml and place your environments URL in the file
 + run ``cd <project-root> && ./bin/behat --init``
 + put features in newly created <project-root>/features directory

Phpunit does not require any further setup and is handled by the configuration of scripts and composer.

### Tests

Tests could be directly executed using behat and phpunit(or the script shipping with Drupal.)

This leaves a lot of options for configuring and varying coverage.

In order to ensure that all developers and the CI execute the tests as agreed upon by all people tasked with driving this project
the tests should be run using the provided scripts under
<project-root>/xi/scripts.

This ensures specific parametersettings and a fixed set of tests to be run.

The unit-test script allows for passing parameters directly to the script wrapped.
See "-h"-switch for details.

The behat-script does not but is not required as it should be configured using behat.yml anyways.
For options see "-h"-switch as well.

All XML-Reports are logged into the directory <project-root>/testreports if appropriate switch is given.


Another advantage to this approach is to decouple the workflow from the 
underlying tools being used. e.g. 
using phpunit-directly instead of the run-tests.sh-script in case more control is needed.


# Behat
### Important Switches
 + --init : initializing the workspace for behat
 + -h : printing detailed help
 + --story-syntax : gives you a rough structure for your *.feature-files
 + -dl : shows definitions usable for *.feature-file 
 + -di : s.a. but with more info