#!/bin/bash
docker run -P -v /path/to/this/folder:/wraithy -w='/wraithy' bbcnews/wraith capture capture.yaml
