#!/bin/bash

set -e

chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Start Nginx in the foreground
nginx

exec "$@"
