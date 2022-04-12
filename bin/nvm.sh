#!/bin/bash

# use it: NODE_VERSION=--lts YARN_VERSION=1.22.10 . bin/nvm.sh [install]

DEFAULT_NODE_VERSION="--lts"
DEFAULT_YARN_VERSION="1.22.10"
DEFAULT_NVM_DIR="$(realpath $(dirname "${BASH_SOURCE-$0}"))/.nvm"

####################################
####    Do not change below!    ####
####################################

: "${NODE_VERSION:=$DEFAULT_NODE_VERSION}"
: "${YARN_VERSION:=$DEFAULT_YARN_VERSION}"
: "${NVM_BASE_DIR:=$DEFAULT_NVM_DIR}"

# ensure our NVM_DIR is set (used by some NVM scripts)
export NVM_DIR="${NVM_BASE_DIR}"

if [ "x${1}" = "xinstall" -o ! -d "$NVM_DIR" ]; then
    # cleanup directory, in case of forced install
    if [ -d "$NVM_DIR" ]; then
        rm -rf "$NVM_DIR"
    fi

    # auto install/update nvm
    OLD_CWD="$(pwd)"
    if [ ! -d "$NVM_DIR" ]; then
        git clone https://github.com/nvm-sh/nvm.git "$NVM_DIR"
        cd "$NVM_DIR"
    else
        cd "$NVM_DIR"
        git fetch -p
    fi
    # checkout latest release
    git -c advice.detachedHead=false checkout `git describe --abbrev=0 --tags --match "v[0-9]*" $(git rev-list --tags --max-count=1)`
    cd "$OLD_CWD"

    # Activate configured environment
    [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"

    # Install node.js + npm
    nvm install $NODE_VERSION

    # Install yarn
    if [ "$($(which npm) list --depth=0 -g yarn | grep "yarn@$YARN_VERSION" | wc -l)" = "0" ]; then
        $(which npm) install -g "yarn@$YARN_VERSION"
    fi

    # Some debugging info
    echo "NVM version: $(nvm --version)"
    echo "Node.js version: $($(which node) --version)"
    echo "NPM version: $($(which npm) --version)"
    echo "Yarn version: $($(which yarn) --version)"
else
    # Activate configured environment
    [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"
fi
