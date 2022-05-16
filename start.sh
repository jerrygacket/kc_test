#!/bin/bash

docker stop $(docker ps -aq)
echo ""

if [ -n "$1" ]; then 
  projName=$(sed 's/\/*$//' <<< "$1")
else
  ls -d $HOME/DOCKER/*/|sed -e 's/\/*$//'
  read -p "запустить: " projName
fi

if [ -d "$projName" ]; then
  echo -e "\033[0;32mЗапускаем ${projName}\033[0m"
  cd $projName
  docker-compose up -d --remove-orphans
fi
