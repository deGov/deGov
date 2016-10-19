#!/bin/bash

# Use this script to update the local node version
# to the one we need for the theme
# at the root level of the theme do ./tools/update-node.sh

# Versions of node can be found at https://nodejs.org/en/download/releases/

# Create directories
echo "Creating local node directory …"
cd ~
mkdir -p .local/bin
mkdir -p .local/node

# Download desired version(s) of node and link it
echo "Downloading node version 6.2.0 …"
cd .local/node
wget https://nodejs.org/download/release/v6.2.0/node-v6.2.0-linux-x64.tar.gz
echo "Extracting node …"
tar -xf node-v6.2.0-linux-x64.tar.gz
echo "Linking node and npm binary …"
ln -s node-v6.2.0-linux-x64 active
cd ../bin
ln -s ../node/active/bin/node
ln -s ../node/active/bin/npm

# Override path to make node and npm your standard version
echo 'export PATH=$HOME/.local/bin:$PATH' >> ~/.bashrc

# Message to make user happy
echo '> Log out and in, and you will see the desired version of node!'
