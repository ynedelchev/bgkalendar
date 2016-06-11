@echo off


set basedir=..
set src=%basedir%\src
set lib=%basedir%\lib
set build=%basedir%\build


echo base   %basedir%
echo src:   %src%
echo lib:   %lib%
echo build: %build%
    
ant "-Dbase=%basedir%" "-Dsrc=%src%" "-Dlib=%lib%" "-Dbuild=%build%" -buildfile "%build%\build.xml" 
