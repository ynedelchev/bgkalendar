#!/bin/bash

#ANT_HOME="/usr/share/ant"
#JAVA_HOME="/usr/lib/jvm/java-7-openjdk-i386/jre"
TOMCAT_HOME=/usr/local/prog/tomcat


if [ -z "$ANT_HOME"  ]
then
    if which ant 2>/dev/null >&2
    then


        OLD=`pwd`
        ANT_HOME=`which ant`
        DIR=`dirname $ANT_HOME`
        BASE=`basename $ANT_HOME`
        cd "$DIR"
        DIR=`pwd`
        ANT_HOME="$DIR/$BASE"
        
        
        while readlink "$ANT_HOME" 
        do
            ANT_HOME=`readlink $ANT_HOME`
            DIR=`dirname $ANT_HOME`
            BASE=`basename $ANT_HOME`
            cd "$DIR"
            DIR=`pwd`
            ANT_HOME="$DIR/$BASE"
        done

        DIR=`dirname $ANT_HOME`
        cd "$DIR/.."
        ANT_HOME=`pwd`
        cd "$OLD" 
    fi 
fi

if [ -z "$JAVA_HOME" ]
then
    if which java 2>/dev/null >&2
    then 
        OLD=`pwd`
        JAVA_HOME=`which java`
        DIR=`dirname $JAVA_HOME`
        BASE=`basename $JAVA_HOME`
        cd "$DIR"
        DIR=`pwd`
        JAVA_HOME="$DIR/$BASE"

        while readlink "$JAVA_HOME"
        do
            JAVA_HOME=`readlink $JAVA_HOME`
            DIR=`dirname $JAVA_HOME`
            BASE=`basename $JAVA_HOME`
            cd "$DIR"
            DIR=`pwd`
            JAVA_HOME="$DIR/$BASE"
        done

        DIR=`dirname $JAVA_HOME`
        cd "$DIR/.."
        JAVA_HOME=`pwd`
        DIR=`dirname $JAVA_HOME`
        BASE=`basename $JAVA_HOME`
        if [ "$BASE" == "jre" ] 
        then 
           JAVA_HOME="$DIR"
        fi 
        cd "$OLD"
    fi 
fi 


if [ -z "$JAVA_HOME" ]
then
   echo "No JAVA_HOME environment variable has been specified."  >&2
   echo "Please specify it with a command like this: "           >&2 
   echo "    JAVA_HOME=<path to Java Virtual Machine Home Dir> " >&2
   echo "and then rerun this script."                            >&2
   exit 1 
fi 

if [ -z "$ANT_HOME" ]
then
   echo "No ant command has been found on your system" >&2
   echo "If you are running a debian like system " >&2
   echo "knoppix,ubinto etc...   then just execute " >&2
   echo "    apt-get install ant" >&2
   echo "in order to install ant and rerun this build script." >&2
   exit 2
fi

if [ -z "$TOMCAT_HOME"  ]
then
   echo "No TOMCAT_HOME environment variable has been specified."  >&2
   echo "Please specify it with a command like this: "             >&2 
   echo "    TOMCAT_HOME=<path to Tomcat Home Dir> "               >&2
   echo "and then rerun this script."                              >&2
   exit 3 
fi

export JAVA_HOME ANT_HOME

PWD=`pwd`
echo $0
DIR=`dirname $0`
cd "$DIR/.."
basedir=`pwd`
src="$basedir/src"
lib="$basedir/lib"
build="$basedir/build"
echo "base:  $basedir"
echo "src:   $src"
echo "lib:   $lib"
echo "build: $build"

echo "JAVA_HOME:   $JAVA_HOME"
echo "ANT_HOME:    $ANT_HOME"

"$ANT_HOME/bin/ant" -Dbase="$basedir" -Dsrc="$src" -Dlib="$lib" -Dbuild="$build" -Dtomcat="$TOMCAT_HOME" -buildfile "$build/build.xml" "$@"

cd "$PWD"
