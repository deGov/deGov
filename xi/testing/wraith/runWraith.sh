#!/bin/bash

printHelp() {
 echo "bash <scriptname>.sh [-x][-h][-v][-f <arg>][-d <arg>][-c <arg>][*]"
 echo ""
 echo "  Wrapper for wraith"
 echo "  -h prints this help"
 echo "  -v absolute path to the volume to use"
 echo "  -o operation(capture/init/history) to use (default capture)"
 echo "  -c the name of the configuration-file in volume to use(default capture.yaml)"
}

volume=`pwd -P`
operation="capture"
configFile="capture.yaml"

while getopts :v:o:c:h opt; do
 if [[ "$opt" == "v" ]]; then
   volume="${OPTARG}"
 elif [[ "$opt" == "o" ]]; then
   operation="${OPTARG}"
 elif [[ "$opt" == "c" ]]; then
   configFile="${OPTARG}"
 elif [[ "$opt" == "h" ]]; then
   printHelp
   exit 0
 fi
done

docker run -P -v $volume:/wraithy -w='/wraithy' bbcnews/wraith $operation $configFile
