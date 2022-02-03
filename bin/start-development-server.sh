#!/bin/sh

set -e

if [ -z "$PORT" ];
then
    PORT=8080
fi

php -S 0.0.0.0:$PORT -t public/
