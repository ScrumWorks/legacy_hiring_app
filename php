#!/bin/bash

docker-compose exec -e COLUMNS="`tput cols`" -e LINES="`tput lines`" -u php php bash