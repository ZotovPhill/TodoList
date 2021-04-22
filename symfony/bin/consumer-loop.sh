#!/usr/bin/env sh
set -ex

file=/tmp/stop_symfony_consumers
while [ ! -f "$file" ];
do
  sleep 1s
  php bin/console messenger:consume $@
done