#!/bin/bash

testSuiteToRun="--testsuite unit"

# Define a timestamp function
timestamp() {
  date +"%Y-%m-%d"
}

# getting nice path for projectroot
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
projectRoot=$(dirname $DIR)
projectRoot=$(dirname $projectRoot)

parameters=($testSuiteToRun)

printHelp() {
  echo "bash runUnitTests.sh [-x][-h][-v][-f <arg>][-d <arg>][-c <arg>][*]"
  echo ""
  echo "  Wrapper for phpunit"
  echo "  -h prints this help"
  echo "  -g group of unit-tests to run (e.g. user)"
  echo "  -p <arg> path to UnitTest/Directory to test, relative from core-directory"
  echo "  -x enables xml-reporting"
  echo "  All subsequent parameters(first unknown switch onwards) are passed to PHPUnit"
  echo "  To see all paramters available run 'phpunit -h'"
}

# processing switches in silentmode, -f and -c are expected to have parameters
# man bash searching for getopts will explain best
while getopts :g:p:xh opt; do
  if [[ "$opt" == "p" ]]; then
    unitTestsToRun=" ${OPTARG}"
  elif [[ "$opt" == "g" ]]; then
    parameters+=("--group ${OPTARG}")
  elif [[ "$opt" == "x" ]]; then
    parameters+=("--log-junit ${projectRoot}/testreports/unit-$(timestamp).xml")
  elif [[ "$opt" == "h" ]]; then
    printHelp
    exit 0
  fi
done

parameters+=($unitTestsToRun)

elementsToShift=$OPTIND

#otherwise shift will do nothing
if [[ $OPTIND -gt $# ]]; then
  elementsToShift=$#
fi

# unshifting all switches that have already been evaluated
shift $elementsToShift

pushd $projectRoot
cd docroot/core

phpunit ${parameters[@]} $@

popd
