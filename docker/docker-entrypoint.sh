#!/bin/bash

set -e

# Start Nginx in the foreground
nginx

exec "$@"
