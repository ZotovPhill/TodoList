#!/usr/bin/env bash
set -ex

rm -rf -R ./var/cache/*
php bin/console cache:clear

sh ./bin/consumer-loop.sh notification_queue_unpacker --no-debug --limit=256 --memory-limit=96M --time-limit=1800 &

wait -n