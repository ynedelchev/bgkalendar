Oin Calendar Project
====================

There have been lots of researches regarding how old Bulgarians have measured 
times and the researches showed that there has been an Old Bulgarian calendar 
which has been (according to most researchers) solar based.

This project aims to provide a library and a 
[web-site](http://bgkalendar.no-ip.info/bgkalendar/) for calculation of the 
current year, month and day according to the assumptive Old Bulgarian calendar.

Calculation is based on some assumptions. For example when does the calendar 
begin. When is day 1, month 1 from year 1, and others. 

This calendar and library is not to be assumed an extensive research or the 
final source of truth at all.  

Please feel free to obtain/use/modify the code according to your own research. 

Java Library
============
This project offers a nice java library for Bulgarian Calendar calculations. 
For building it uses the [ant](https://ant.apache.org/)  build system. To build 
it go to the `build` sub-directory and run `ant`: 

````
cd build
ant
````

Testing the Java Library
------------------------
There is a simple java servlet that could be deployed on top of a web container 
such as Tomcat and tested. It would present containing a complete calendar table 
with all of the months, days, days of week, etc... according to the Old Bulgarian 
calendar, and will also mark the current day with dark blue in the calendar table. 

Unfortunately there are no deploy instructions as of yet. 

PHP Library and Web Site
========================

Under the `phpsite` sub-directory, you can find a PHP version of the library. 
That makes it easy to use that library in your own PHP Web site. 

We also have a sample site with a main page `phpsite/index.php` and some `css` 
styling and so on. Look at the `phpsite/kalendar.html` for an explanation of 
the principles of the calendar.

Sample of this site has been installed on http://bgkalendar.no-ip.info/bgkalendar.

Gregorian and Julian Calendar
=============================
Although the primary goal of the project was to calculate the current date based 
on the Old Bulgarian calendar, it has been designed in a generic and extendable 
way, so it in fact provides an API and a framework for calculating the date on 
any calendar (not even just solar based calendars). 

Then 3 implementations on top of this API interface has been implemented: 

  - Implementation of the Julian calendar
  - Implementation of the Gregorian calendar (the modern calendar used in European countries)
  - Implementation of the Old Bulgarain calendar.

