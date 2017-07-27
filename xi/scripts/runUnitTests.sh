#!/bin/bash

unitTestsToRun="--all"
dataBaseToUse="--sqlite /tmpfs/test.sqlite"

# getting nice path for projectroot
projectRoot=$(dirname $(realpath $0))
projectRoot=$(dirname $projectRoot)
projectRoot=$(dirname $projectRoot)

parameters=($dataBaseToUse)

printHelp() {
  echo "bash runUnitTests.sh [-x][-h][-v][-f <arg>][-d <arg>][-c <arg>][*]"
  echo ""
  echo "  Wrapper for Drupalscript degove/docroot/core/scripts/run-tests.sh"
  echo "  -h prints this help"
  echo "  -v verbose output"
  echo "  -f <arg> tests only unit-tests in file"
  echo "  -d <arg> tests only unit-tests in directory"
  echo "  -c <arg> tests only unit-tests in class"
  echo "  -x enables xml-reporting"
  echo "  All subsequent parameters(first unknown switch onwards) are passed to the drupal-script-unchanged"
  echo "  To pass all parameters on to the wrapped script (e.g. --help) use the parameters '- --help'"
}

# processing switches in silentmode, -f and -c are expected to have parameters
# man bash searching for getopts will explain best
while getopts :f:d:c:xvh opt; do
  if [[ "$opt" == "f" ]]; then
    unitTestsToRun="--file ${OPTARG}"
  elif [[ "$opt" == "d" ]]; then
    unitTestsToRun="--directory ${OPTARG}"
  elif [[ "$opt" == "c" ]]; then
    unitTestsToRun="--class ${OPTARG}"
  elif [[ "$opt" == "v" ]]; then
    parameters+=("--verbose")
  elif [[ "$opt" == "x" ]]; then
    parameters+=("--xml ${projectRoot}/testreports")
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

php -f ./scripts/run-tests.sh -- ${parameters[@]} $@

popd