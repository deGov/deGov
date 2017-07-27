#!/bin/bash

# no tags means run all features
tagsToRun=""

# getting nice path for projectroot
projectRoot=$(dirname $(realpath $0))
projectRoot=$(dirname $projectRoot)
projectRoot=$(dirname $projectRoot)

parameters=()

printHelp() {
  echo "bash runBehatTests.sh [tagname]"
  echo ""
  echo "  Wrapper for behat-script"
  echo "  -h prints this help"
  echo "  -t <arg> tag to run"
  echo "  -x enables xml-reporting, mutes regular output"
}

# processing switches in silentmode, -f and -c are expected to have parameters
# man bash searching for getopts will explain best
while getopts :t:xh opt; do
  if [[ "$opt" == "t" ]]; then
    tagsToRun="--tags @${OPTARG}"
  elif [[ "$opt" == "x" ]]; then
    parameters+=("-f junit -o testreports")
  elif [[ "$opt" == "h" ]]; then
    printHelp
    exit 0
  fi
done

parameters+=($tagsToRun)

pushd $projectRoot

./bin/behat ${parameters[@]}

popd