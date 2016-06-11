


tomcat=/usr/local/prog/tomcat

all:
	$(tomcat)/bin/shutdown.sh 
	./build.sh jar
	rm -rf $(tomcat)/logs/*
	rm -rf $(tomcat)/webapps/bgcalendar/WEB-INF/lib 
	rm -rf ${tomcat}/work/*
	mkdir -p ${tomcat}/webapps/bgcalendar/WEB-INF/lib
	cp dist/lib/bgcalendar.jar ${tomcat}/webapps/bgcalendar/WEB-INF/lib
	sleep 5
	$(tomcat)/bin/startup.sh
