<!-- Please use markdown-toc -i README.md to update the table of contents -->
<!-- -->
**Table of Contents**  *generated with [Markdown-TOC](https://www.npmjs.com/package/markdown-toc#install)*

<!-- toc -->

- [Welcome to the Bulgarian Calendar Project](#welcome-to-the-bulgarian-calendar-project)
- [Java Library](#java-library)
  * [Testing the Java Library](#testing-the-java-library)
- [PHP Library and Web Site](#php-library-and-web-site)
- [Gregorian and Julian Calendar](#gregorian-and-julian-calendar)
- [Old Bulgarain Calendar Principles](#old-bulgarain-calendar-principles)
  * [Beginning of the Calendar](#beginning-of-the-calendar)
  * [Structure of the year](#structure-of-the-year)
  * [Cycles for correction of the calendar](#cycles-for-correction-of-the-calendar)
- [License](#license)

<!-- tocstop -->

Welcome to the Bulgarian Calendar Project
====================

There have been lots of researches regarding how old Bulgarians have measured 
times and the researches showed that there has been an Old Bulgarian calendar 
which has been (according to most researchers) solar based.

This project aims to provide a library and a 
[web-site](http://bgkalendar.com/) for calculation of the 
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
styling and so on. Look at the [`phpsite/kalendar.html`](https://github.com/ynedelchev/bgkalendar/blob/master/phpsite/kalendar.html) 
for an explanation of the principles of the calendar.

Sample of this site has been installed on [http://bgkalendar.com](http://bgkalendar.com).

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

Old Bulgarain Calendar Principles
=================================

The Bulgarian calendar is the calendar of the ancient Bulgarians restored from 
written historical data 
[Nominalia of the Bulgarian khans](https://en.wikipedia.org/wiki/Nominalia_of_the_Bulgarian_khans) 
and the folk tales and legends. 
There are studies of various scholars who sometimes quite differ in  
conclusions reached.

Beginning of the Calendar
-------------------------
Most researchers accept the starting point on the 22-nd day of the winter 
solstice (December 21) during the year 5505 BC – in other words, we can assume 
that the first year of the Bulgarian calendar coincides almost completely 
with 5504 BC in the Gregorian calendar.

````
+---------------------------------------+------------------------------+
| .. 20 21 22 23 24 25 26 27 28 29 30 31| 1 2 3 4 5 6 7 8 9 10 11 ...  |
+-------^-------------------------------+------------------------------+
| December 5505 yr. before Christ       | January 5504 yr. before Ch.  |
+-------^-------------------------------+------------------------------+
        |
        |
        +-------------------------------------------------------------+
        |1  2  3  4  5  6  7  8  9 10 11 12           ...             |
        +-------------------------------------------------------------+
        | First Month of the First year of Old Bulgarian Calendar     |
        +-------------------------------------------------------------+
        ^
        |
        |
        Winter Solar solstice
````

When doing calculations and comparison with the Gregorian and/or Julian calendar, 
please bare in mind that in both Julian and Gregorian calendars there is no zero year - that is to say, 
that 1-st year BC is immediately followed by the 1-st year after Christ.

````
+---------------------------------------+------------------------------+
| .. 20 21 22 23 24 25 26 27 28 29 30 31| 1 2 3 4 5 6 7 8 9 10 11 ...  |
+---------------------------------------+------------------------------+
|        December 1-st year BC          |      January 1 year AC       |
+---------------------------------------+------------------------------+
````

In our calendar model, we have adopted for the start of the calendar to be a year earlier. 
So 21-st of December 5506 BC (Monday according to the Grigorian calendar) was adopted as 
the first day of the Bulgarian calendar.


Structure of the year
---------------------
According to researchers, the year has been divided into 12 months + one or two (in leap years) 
business days, which were beyond the months. Months were grouped in quarters of 3 months. 
First month of each quarter always had 31 days * , and the remaining two months had 30 days. 
So each quarter, there are exactly 91 days or 364 days that makes for four quarters. 
At the end of the year (or at the beginning according to some researchers) there has been 
one additional day that is outside months and was called Eni. 
The analogue of the day Eni is today's Ignazhden (St. Ignatius day), also called `ednazhden`. 
Counting the day Eni, the year had already 365 days. Similar to the Julian and Gregorian 
calendar once on every 4 years additional leap day (midsummer day) was added based on some rules, 
which we would reviw further on. The leap day (midsummer day), just like the day Eni was beyond any month.
It was put after the end of the 6-th month, before the start of the 7-th month. 
The leap day was called Behti. The analogue of the Midsummer day is today's [Enyovden](https://en.wikipedia.org/wiki/Saint_John's_Eve) .

In our model the conditional Behti is represented as the last 31-st day in the 6-th month only on leap years, 
Eni is represented as the last 31-st day in the 12-th month.

````
                                        YEAR                                 
                                                                             
            First Month             Second Month           Third Month
                                                                             
        I II III IV  V VI VII   I II III IV  V VI VII   I II III IV  V VI VII
                                                                              
        1  2  3   4  5  6  7              1  2  3  4                    1  2  
        8  9 10  11 12 13 14    5  6  7   8  9 10 11    3  4  5   6  7  8  9
 Q1     15 16 17  18 19 20 21   12 13 14  15 16 17 18   10 11 12  13 14 15 16
        22 23 24  25 26 27 28   19 20 21  22 23 24 25   17 18 19  20 21 22 23
        29 30 31                26 27 28  29 30         24 25 26  27 28 29 30
                                                                             
                                                                             
            Forth Month              Fifth Month             Sixth Month
                                                                             
        I II III IV  V VI VII   I II III IV  V VI VII   I II III IV  V VI VII
                                                                              
        1  2  3   4  5  6  7              1  2  3  4                    1  2  
        8  9 10  11 12 13 14    5  6  7   8  9 10 11    3  4  5   6  7  8  9
 Q2    15 16 17  18 19 20 21   12 13 14  15 16 17 18   10 11 12  13 14 15 16
       22 23 24  25 26 27 28   19 20 21  22 23 24 25   17 18 19  20 21 22 23
       29 30 31                26 27 28  29 30         24 25 26  27 28 29 30
                                                                            
                                                          Day Behty (31-st) - only on leap years
                                                                            
            Sevent Month             Eight Month             Nineth Month
                                                                             
        I II III IV  V VI VII   I II III IV  V VI VII   I II III IV  V VI VII
                                                                             
        1  2  3   4  5  6  7              1  2  3  4                    1  2  
        8  9 10  11 12 13 14    5  6  7   8  9 10 11    3  4  5   6  7  8  9
 Q3    15 16 17  18 19 20 21   12 13 14  15 16 17 18   10 11 12  13 14 15 16
       22 23 24  25 26 27 28   19 20 21  22 23 24 25   17 18 19  20 21 22 23
       29 30 31                26 27 28  29 30         24 25 26  27 28 29 30
                                                                             
                                                                             
            Tenth Month              Eleventh Month         Twelveth Month   
                                                                             
        I II III IV  V VI VII   I II III IV  V VI VII   I II III IV  V VI VII
                                                                             
        1  2  3   4  5  6  7              1  2  3  4                    1  2  
        8  9 10  11 12 13 14    5  6  7   8  9 10 11    3  4  5   6  7  8  9
 Q4    15 16 17  18 19 20 21   12 13 14  15 16 17 18   10 11 12  13 14 15 16
       22 23 24  25 26 27 28   19 20 21  22 23 24 25   17 18 19  20 21 22 23
       29 30 31                26 27 28  29 30         24 25 26  27 28 29 30
                                                                              
                                                          Day Eni (31-st)

````

It is assumed that the days Eni and Behti, are not counted as days of a week. 
These are the so-called days which are not «not counted». 
Without them, the rest of the days that count, form exactly 52 weeks. 
So if the year begins on Monday, the next year will also begin on Monday and
each calendar date remains fixed forever in a specific day of the week.

Some researchers suggest that Bulgarian week began with Sunday. Basis for such an 
assumption is the name of a day Wednesday - `sryada`  - that means in Bulgarian 'middle' (of the week).
An alternative assumption is that Monday was widely adopted as the first day of the week. 
The grounds for such an alternative assumption are the names of the following days: Tuesday (`vtornik`), 
Thursday (`chetvartak`) and Friday (`petak`) - meaning, respectively, second, fourth and fifth (day of the week)  - in bulgarian 
sekond - `vtori`, fourth - `chetvarti`, fifth - `peti`. That is to say if Tuesday is the second day, 
then Monday is supposed to be the first. In our model, we accept contingent names of days of the week - 
1-st, 2-nd, 3-rd, 4-th, 5-th, 6-th and 7-th.

In the table above, we have represented them with the latin numbers (I, II, III, IV, V, VI, VII) to destinguish them 
from the days of the month.

In any case, the days of the week do not match to the days of the week that we know from the modern Gregorian calendar. 
This is because in the modern calendar, there are no days that are not counted and are not included in the 
composition of the week. As we said in the Bulgarian calendar, such days are Eni and Behti.


`*`: There are also hypotheses, that the first and second month of each quarter had 30 days, but the third had 31 days. 
Common across all hypotheses is that the year is divided into quarters of 91 days.

Cycles for correction of the calendar
-------------------------------------
Tropical Earth year - that is the time for which the Earth makes one complete lap around the Sun, equals 190 419 365.242 Earth days - that is to say 365 days, 5 hours, 48 minutes and 45.5 seconds. So in a calendar year of 365 days, it goes faster with a quarter day (5 hours, 48 minutes and seconds 45.5) each year. After four years, the calendar year is starting approximately 1 day before completing the astronomical round of the Earth around the Sun.


To stay in sync, the calendar year need to be corrected by adding a leap day every four years - the so-called day Behti that is added at the end of the 6th month. This adjustment, however, is not sufficient because the high gain of the calendar was not exactly a day (24 hours). It is 23 hours, 15 minutes and 2 seconds. So after adding the leap day the calendar begins to lag.


This requires a system of additional adjustments. This system divides the calendar into periods, as shown below.


### Four year period


Every forth year has an additional leap day named Behti at the end of the 6-th month. A year with a leap day would be called a leap year. An year without a leap day would be called a non-leap year.

````
   +----------------+-----------------+---------------+-----------------+
   | First Non Leap | Second Non Leap | Thir Non Leap | *Fourth LEAP*   |
   | Year           | Year            | Year          | *Year*          |
   +----------------+-----------------+---------------+-----------------+

````

### Twelve year period

Three four - year periods form one 12 year period. This period is not characterized by a calendar adjustment, but what makes it specila is that each year from the 12 year cycle has an animal assigned to it - that is why this 12 year cycle is also called animalian cycle. Various researchers adopt different order of animals, as well as different starting animal. The names of the animals are also controversial. Here are some examples:

````
 +---------------------------------------------------------------------------------------------+
 |                                       According To                                          |
 +-------------------------+---------------------------------------------+---------------------+
 |       Georgi Krustev    |             Yordan Vulchev                  |    Petur Dobrev     |
 +-------------------------+---------------------------------------------+---------------------+
 | animal       | name(s)  |    animal    |          name(s)             |  animal  |  name(s) |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Pig          |   Dox    | Pig          | dox, dok, prase              |                     |
 +--------------+----------+--------------+------------------------------+---------------------+
 | Mouse        |   Karan  | Mouse        | somor, shushi                | Mouse    | Somor    |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Ox           |   Shegor | Ox           | shegor, kuvrat, buza, busman | Ox       | Shegor   |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Snow Leopard |   Barus  | Tiger        | bars, parus, barus           | -        |          |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Rabbit       |   Dvan   | Rabbit       | dvansh                       | Rabbit   | Dvan     |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Dragon       |   Hala   | Dragon-Snake | ver, dragun, kala, slav      | Dragon   | Ver      |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Snake        |          | Snake        | dilom, delyan, attilla       | Snake    | Dilom    |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Horse        |   Tag    | Horse        | tek, tag, tih, alasha        | Horse    | Teku     |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Monkey       |   Pisin  | Monkey       | pesin, pisin                 | -        | -        |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Ram          |          | Ram          | suruh, sever, rasate         | -        | -        |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Cock         |   Tox    | Cock         | toh, tah                     | Cock     | Toh      |
 +--------------+----------+--------------+------------------------------+----------+----------+
 | Dog          |   Et-h   | Dog          | et-h                         | Dog      | Et-h     |
 +--------------+----------+--------------+------------------------------+----------+----------+
                                                                         | Boar     | Dohs     |
                                                                         +----------+----------+
```` 
Each 12-year period has been either male or female. In a male period - all years within this period were male - the corresponding animals have been male. In a female period - all years within the period comply with the animals of the female sex. After each male 12 year period, a female one follows. After that a mail period again and so on...

### Sixty year period (star day)

A period of 60 years equals exactly to 5 twelve-year cycles or 15 four-year cycles. It was conventially called "star day" Yordan Vulchev. Since the 60-year cycle is multiple of 4 year periods, then it, generally, ends in a leap year. Such a star day would be called - a leap star day.


In certain cases, for the correction of the calendar, the leap day of the last year in the 60 year period neet to be taken away. In such case, we will call the star day a non leap star day.

````
                  Leap Star Day                                         NON Leap Star Day              
  +-------+--------------+------+---------------+       +-------+--------------+------+----------------+
  | BLACK | Four Yrs: 1  | № 1. | Non leap year |       | BLACK | Four Yrs: 1  | № 1. | Non leap year  |
  |       |              | № 2. | Non leap year |       |       |              | № 2. | Non leap year  |
  |       |              | № 3. | Non leap year |       |       |              | № 3. | Non leap year  |
  |       |              | № 4. | Leap year     |       |       |              | № 4. | Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 2  | № 5. | Non leap year |       |       | Four Yrs: 2  | № 5. | Non leap year  |
  |       |              | № 6. | Non leap year |       |       |              | № 6. | Non leap year  |
  |       |              | № 7. | Non leap year |       |       |              | № 7. | Non leap year  |
  |       |              | № 8. | Leap year     |       |       |              | № 8. | Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 3  | № 9. | Non leap year |       |       | Four Yrs: 3  | № 9. | Non leap year  |
  |       |              | № 10.| Non leap year |       |       |              | № 10.| Non leap year  |
  |       |              | № 11.| Non leap year |       |       |              | № 11.| Non leap year  |
  |       |              | № 12.| Leap year     |       |       |              | № 12.| Leap year      |
  +---------------------------------------------+       +----------------------------------------------+
  | RED   | Four Yrs: 4  | № 13.| Non leap year |       | RED   | Four Yrs: 4  | № 13.| Non leap year  |
  |       |              | № 14.| Non leap year |       |       |              | № 14.| Non leap year  |
  |       |              | № 15.| Non leap year |       |       |              | № 15.| Non leap year  |
  |       |              | № 16.| Leap year     |       |       |              | № 16.| Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 5  | № 17.| Non leap year |       |       | Four Yrs: 5  | № 17.| Non leap year  |
  |       |              | № 18.| Non leap year |       |       |              | № 18.| Non leap year  |
  |       |              | № 19.| Non leap year |       |       |              | № 19.| Non leap year  |
  |       |              | № 20.| Leap year     |       |       |              | № 20.| Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 6  | № 21.| Non leap year |       |       | Four Yrs: 6  | № 21.| Non leap year  |
  |       |              | № 22.| Non leap year |       |       |              | № 22.| Non leap year  |
  |       |              | № 23.| Non leap year |       |       |              | № 23.| Non leap year  |
  |       |              | № 24.| Leap year     |       |       |              | № 24.| Leap year      |
  +---------------------------------------------+       +----------------------------------------------+
  | Y     | Four Yrs: 7  | № 25.| Non leap year |       | Y     | Four Yrs: 7  | № 25.| Non leap year  |
  | E     |              | № 26.| Non leap year |       | E     |              | № 26.| Non leap year  |
  | L     |              | № 27.| Non leap year |       | L     |              | № 27.| Non leap year  |
  | L     |              | № 28.| Leap year     |       | L     |              | № 28.| Leap year      |
  | O     |-------------------------------------+       | O     |--------------------------------------+
  | W     | Four Yrs: 8  | № 29.| Non leap year |       | W     | Four Yrs: 8  | № 29.| Non leap year  |
  |       |              | № 30.| Non leap year |       |       |              | № 30.| Non leap year  |
  |       |              | № 31.| Non leap year |       |       |              | № 31.| Non leap year  |
  |       |              | № 32.| Leap year     |       |       |              | № 32.| Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 9  | № 33.| Non leap year |       |       | Four Yrs: 9  | № 33.| Non leap year  |
  |       |              | № 34.| Non leap year |       |       |              | № 34.| Non leap year  |
  |       |              | № 35.| Non leap year |       |       |              | № 35.| Non leap year  |
  |       |              | № 36.| Leap year     |       |       |              | № 36.| Leap year      |
  +---------------------------------------------+       +----------------------------------------------+
  | BLUE  | Four Yrs: 10 | № 37.| Non leap year |       | BLUE  | Four Yrs: 10 | № 37.| Non leap year  |
  |       |              | № 38.| Non leap year |       |       |              | № 38.| Non leap year  |
  |       |              | № 39.| Non leap year |       |       |              | № 39.| Non leap year  |
  |       |              | № 40.| Leap year     |       |       |              | № 40.| Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 11 | № 41.| Non leap year |       |       | Four Yrs: 11 | № 41.| Non leap year  |
  |       |              | № 42.| Non leap year |       |       |              | № 42.| Non leap year  |
  |       |              | № 43.| Non leap year |       |       |              | № 43.| Non leap year  |
  |       |              | № 44.| Leap year     |       |       |              | № 44.| Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 12 | № 45.| Non leap year |       |       | Four Yrs: 12 | № 45.| Non leap year  |
  |       |              | № 46.| Non leap year |       |       |              | № 46.| Non leap year  |
  |       |              | № 47.| Non leap year |       |       |              | № 37.| Non leap year  |
  |       |              | № 48.| Leap year     |       |       |              | № 48.| Leap year      |
  +---------------------------------------------+       +----------------------------------------------+
  | WHITE | Four Yrs: 13 | № 49.| Non leap year |       | WHITE | Four Yrs: 13 | № 49.| Non leap year  |
  |       |              | № 50.| Non leap year |       |       |              | № 50.| Non leap year  |
  |       |              | № 51.| Non leap year |       |       |              | № 51.| Non leap year  |
  |       |              | № 52.| Leap year     |       |       |              | № 52.| Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 14 | № 53.| Non leap year |       |       | Four Yrs: 14 | № 53.| Non leap year  |
  |       |              | № 54.| Non leap year |       |       |              | № 54.| Non leap year  |
  |       |              | № 55.| Non leap year |       |       |              | № 55.| Non leap year  |
  |       |              | № 56.| Leap year     |       |       |              | № 56.| Leap year      |
  |       |-------------------------------------+       |       |--------------------------------------+
  |       | Four Yrs: 15 | № 57.| Non leap year |       |       | Four Yrs: 15 | № 57.| Non leap year  |
  |       |              | № 58.| Non leap year |       |       |              | № 58.| Non leap year  |
  |       |              | № 59.| Non leap year |       |       |              | № 59.| Non leap year  |
  |       |              | № 60.| *Leap year*   |       |       |              | № 60.| *Non leap year*|
  +---------------------------------------------+       +----------------------------------------------+
````

License
=======

[MIT License](http://adampritchard.mit-license.org/).
