#!/bin/bash
set -e

if [ -z "$1" ]; then
    cp /etc/nginx/nginx.conf.${ENVIRONMENT} /etc/nginx/nginx.conf
    exec nginx -g "daemon off;"
fi

exec "$@"

