#!/bin/bash

TAG=`date +"%Y-%m-%d"`
docker build . --tag "bgkalendar/bgkalendar:$TAG"
docker login --username=bgkalendar 
docker tag "bgkalendar/bgkalendar:$TAG" bgkalendar/bgkalendar:latest
docker push "bgkalendar/bgkalendar:$TAG"
docker push bgkalendar/bgkalendar:latest

echo "Now Run: "
echo "docker run --privileged --detach=true --rm -p 80:80 bgkalendar/bgkalendar"

echo ""
echo "To see running container id"
echo "    docker ps | grep bgkalendar"
echo "    CONTAINER=\`docker ps | grep bgkalendar | cut -f1 -d' '\`"

echo ""
echo "To enter the running container"
echo "    docker exec -it \$CONTAINER bash"
# docker run --rm -p 80:80 bgkalendar 
