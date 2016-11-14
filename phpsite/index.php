<!DOCTYPE html>
<?php
require_once("leto/api/Leto.php");
require_once("leto/api/LetoException.php");
require_once("leto/api/LetoExceptionUnrecoverable.php");
require_once("leto/api/LetoPeriod.php");
require_once("leto/api/LetoPeriodStructure.php");
require_once("leto/api/LetoPeriodType.php");
require_once("leto/base/LetoBase.php");
require_once("leto/base/LetoCorrectnessChecks.php");
require_once("leto/base/LetoPeriodBean.php");
require_once("leto/base/LetoPeriodStructureBean.php");
require_once("leto/base/LetoPeriodTypeBase.php");
require_once("leto/base/LetoPeriodTypeBean.php");
require_once("leto/impl/bulgarian/LetoBulgarianMonth.php");
require_once("leto/impl/bulgarian/LetoBulgarian.php");
require_once("leto/impl/gregorian/LetoGregorianMonth.php");
require_once("leto/impl/gregorian/LetoGregorian.php");

function formatMinimumDigits($display, $minimumLetters) {
     return str_pad($display, $minimumLetters, '0', STR_PAD_LEFT);
}

function seqPrefixN($year) {
    if (bccomp($year, '10') >= 0 && bccomp($year, '20')  <= 0) {
        return $year . "-то";
    }
    $rem = bcmod($year, '10');
    switch ($rem) {
        case '1':
            return "" . $year . "-во";
        case '2':
            return "" . $year . "-ро";
        case '7':
        case '8':
            return "" . $year . "-мо";
        default:
            return "" . $year . "-то";
    }
}
function seqPrefixF($year) {
    if (bccomp($year, '10') >= 0 && bccomp($year, '20')  <= 0) {
        return $year . "-та";
    }
    $rem = bcmod($year, '10');
    switch ($rem) {
        case '1':
            return "" . $year . "-ва";
        case '2':
            return "" . $year . "-ра";
        case '7':
        case '8':
            return "" . $year . "-ма";
        default:
            return "" . $year . "-та";
    }
}
function seqPrefixM($day) {
    if (bccomp($day, '10') >= 0 && bccomp($day, '20')  <= 0) {
        return $day . "-ти";
    }
    $rem = bcmod($day, '10');
    switch ($rem) {
        case '1':
            return "" . $day . "-ви";
        case '2':
            return "" . $day . "-ри";
        case '7':
        case '8':
            return "" . $day . "-ми";
        default:
            return "" . $day . "-ти";
    }
}
/**
 * This function assumes that months are 1 - 12 and days 1 - 31.
 */
function getBulgarianWeekDay($month, $day) {
  if ($month == 6 && $day == 31) {
      return 0;
  }
  if ($month == 12 && $day == 31) {
      return 0;
  }
  switch ($month) {
      case 1: case 4: case 7: case 10: return ( ($day - 1) % 7 ) + 1;
      case 2: case 5: case 8: case 11: return ( ($day - 4) % 7 ) + 1;
      case 3: case 6: case 9: case 12: return ( ($day - 6) % 7 ) + 1;
      default:                         return 0;
  }
}

function getBckGrnd($indexbg, $daysbgFromStartOfCalendar, $wday) {
    return ($indexbg == $daysbgFromStartOfCalendar) ? " today" :   ( ($wday==5)? " subota":(($wday==6)?" nedelya":"") );
}


$WEEKDAYS = array ( "Понеделник", "Вторник", "Сряда", "Четвъртък", "Петък", "Събота", "Неделя" );
$WEEKDAYS_SHORT = array ( "пн", "вт", "ср", "чт", "пт", "сб", "не" );
$PERIOD_NAMES = array ( "Ден", "Месец", "Година", "Четиригодие", "Звезден Ден", 
                        "Звездна Седмица", "Звезден месец" , "Звездна Година", "Звездна Епоха" );
$YEAR_ANIMALS = array ( "Плъх", "Вол", "Барс", "Заек", "Дракон", "Змия", "Кон", "Овен", "Маймуна", "Петел", "Куче", "Глиган");
$YEAR_ANIMALS_BG = array("Сомор", "Шегор", "Вери", "Дванш", "Дракон", "Дилом", "Морин", "Теку", "Маймуна", "Тох", "Етх", "Дохс");
$DETAILS_URL_PARAMETER = "m";
$DAYS_BG_URL_PARAMETER = "db";
$DAYS_GR_URL_PARAMETER = "dg";

$locale = "bg";
$areDetailsVisible = isset($_REQUEST[$DETAILS_URL_PARAMETER]) ? $_REQUEST[$DETAILS_URL_PARAMETER] : null; // details
$daysbgFromStartOfCalendar = isset($_REQUEST[$DAYS_BG_URL_PARAMETER]) ? $_REQUEST[$DAYS_BG_URL_PARAMETER] : null;
$daysgrFromStartOfCalendar = isset($_REQUEST[$DAYS_GR_URL_PARAMETER]) ? $_REQUEST[$DAYS_GR_URL_PARAMETER] : null;
$weekdayCorrection = -2;
$hour    = -1;
$minute  = -1;
$secund  = -1;

$gr = new LetoGregorian();
$bg = new LetoBulgarian();

$daysbgFromStartOfCalendarTillJavaEpoch = $bg->startOfCalendarInDaysBeforeJavaEpoch();
$daysgrFromStartOfCalendarTillJavaEpoch = $gr->startOfCalendarInDaysBeforeJavaEpoch();

if ($daysbgFromStartOfCalendar != null) {
  $daysgrFromStartOfCalendar = $daysbgFromStartOfCalendar - $daysbgFromStartOfCalendarTillJavaEpoch + $daysgrFromStartOfCalendarTillJavaEpoch;
} else if ($daysgrFromStartOfCalendar != null) {
  $daysbgFromStartOfCalendar = $daysgrFromStartOfCalendar - $daysgrFromStartOfCalendarTillJavaEpoch + $daysbgFromStartOfCalendarTillJavaEpoch;
}  

$periodsbg = null;
$periodsgr = null;
if ($daysbgFromStartOfCalendar == null) {
   $timezoneCorrection    = '7200'; // Two hours ahead of GMT in seconds.
   $dailysavingCorrection = '31536000';//(1L * 60L * 60L * 1000L); // One hour ahead of usual winter time. 0 - means winter time.

   $secundsFromJavaEpoch = bcadd(time(), bcadd($timezoneCorrection, $dailysavingCorrection)); // Two hour ahead of GMT
   $secundsInDay = '86400';   // Seconds in a day.
   $remainng = bcmod($secundsFromJavaEpoch, $secundsInDay);  // How much complete days have passed since EPOCH
   $hour     = bcdiv($remainng, '3600', 0);
   $remainng = bcmod($remainng, '3600');
   $minute   = bcdiv($remainng, '60', 0);
   $remainng = bcmod($remainng, '60');
   $secund   = $remainng ;
   $daysFromJavaEpoch = bcdiv($secundsFromJavaEpoch, $secundsInDay, 0);  // How much complete days have passed since EPOCH
   $daysbgFromStartOfCalendar = bcadd($daysbgFromStartOfCalendarTillJavaEpoch, $daysFromJavaEpoch);
   $daysgrFromStartOfCalendar = bcadd($daysgrFromStartOfCalendarTillJavaEpoch, $daysFromJavaEpoch);

   //$periodsbg  = $bg->getToday();
   $periodsbg = $bg->calculateCalendarPeriods($daysbgFromStartOfCalendar);

   //$periodsgr  = $gr->getToday();
   $periodsgr = $gr->calculateCalendarPeriods($daysgrFromStartOfCalendar);
} else {
   $periodsbg = $bg->calculateCalendarPeriods($daysbgFromStartOfCalendar);
   $periodsgr = $gr->calculateCalendarPeriods($daysgrFromStartOfCalendar);
}

if ($periodsbg == null || $periodsgr == null) {
   throw new LetoException("Невъзможно изчисляването на текущата дата поради неизвестна причина.");
}
$daybg       = $periodsbg[0]->getNumber() + 1;
$daygr       = $periodsgr[0]->getNumber() + 1;
$monthbg     = $periodsbg[1]->getNumber() + 1; 
$monthgr     = $periodsgr[1]->getNumber() + 1; 
$monthNamebg = $periodsbg[1]->getStructure()->getName($locale);
$monthNamegr = $periodsgr[1]->getStructure()->getName($locale);
$yearbg      = $periodsbg[2]->getAbsoluteNumber() + 1;
$yeargr      = $periodsgr[2]->getAbsoluteNumber() + 1;
$shortNamebg = $PERIOD_NAMES[0] . ": " . $daybg . ", "
     . $PERIOD_NAMES[1] . ": " . $monthNamebg . ", "
     . $PERIOD_NAMES[2] . ": " . $yearbg . " &nbsp; &nbsp ["
     . formatMinimumDigits($daybg, 2) . "-" . formatMinimumDigits($monthbg, 2) . "-"
     . formatMinimumDigits($yearbg,4) . " "
     . ($hour   == -1 ? "" : formatMinimumDigits($hour, 2) . ":")
     . ($minute == -1 ? "" : formatMinimumDigits($minute, 2) . ": ")
     . ($secund == -1 ? "" : formatMinimumDigits($secund, 2) . "] ");
$daysbg = $periodsbg[0]->getAbsoluteNumber();
$daysgr = $periodsgr[0]->getAbsoluteNumber();
$weekdaybg = (int)(($daysbg + $weekdayCorrection )% 7);
$weekdaygr = (int)(($daysgr + $weekdayCorrection )% 7);

$daysgr = $daysgrFromStartOfCalendar; // Nasty fix for nasty bug. Obvously getAbsoluteNumber() for Gregorian calendar is not OK.

$daybgformatted   = formatMinimumDigits($daybg, 2);
$monthbgformatted = formatMinimumDigits($monthbg, 2);
$yearbgformatted  = formatMinimumDigits($yearbg, 4);

$daygrformatted   = formatMinimumDigits($daygr, 2);
$monthgrformatted = formatMinimumDigits($monthgr, 2);
$yeargrformatted  = formatMinimumDigits($yeargr, 4);

?>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <title>Българският Календар</title>
   <link rel="stylesheet" type="text/css" href="bgkalendar.css" /> 
   <link rel="stylesheet" type="text/css" href="forum.css" /> 
   <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="bgcalendar-ie.css" /> 
   <![endif]-->
   <!--[if !IE]><!-->
        <link rel="stylesheet" type="text/css" href="bgkalendar-nonie.css" /> 
   <!--<![endif]-->

   <script type="text/javascript" src="bgkalendar.js"></script>
   <!--
      These four scripts are needed in order to support the transform css propety and more 
      specifically the rotation by 90 degrees in Internet Explorer. 
      Thanks to 
      http://www.useragentman.com/blog/2010/03/09/cross-browser-css-transforms-even-in-ie/
   -->
   <script type="text/javascript" src="js/EventHelpers.js"></script>
   <script type="text/javascript" src="js/cssQuery-p.js"></script>
   <script type="text/javascript" src="js/jcoglan.com/sylvester.js"></script>
   <script type="text/javascript" src="js/cssSandpaper.js"></script>
   <script type="text/javascript">
     function initialize() {
         windowResized();

          // Initialize Bulgarian Kalendar....

          <?php $indexbg = $periodsbg[2]->startsAtDaysAfterEpoch();?>;
          var indexbg = <?php echo $indexbg;?>;
          var indexgr = 
          <?php echo bcsub($indexbg, bcsub($daysbgFromStartOfCalendarTillJavaEpoch, $daysgrFromStartOfCalendarTillJavaEpoch));?>;
          //var jepochindex = <?php echo bcsub($indexbg, $daysbgFromStartOfCalendarTillJavaEpoch);?>;
          var jepochindex = indexbg;
          var i = 0;
          for (i = 0; i <= (366 + 31); i++) {
             var namebg = "daybg" + (indexbg + i);
             var namegr = "daygr" + (indexgr + i);
             var jepoch = jepochindex + i;

             var bg = document.getElementById(namebg);
             var gr = document.getElementById(namegr);

             if (bg != null) {
                setFuncOnFocus( "onfocus_"     + namebg, namebg, namegr);
                setFuncOnBlur ( "onblur_"      + namebg, namebg, namegr);
                setFuncOnmover( "onmouseover_" + namebg, namebg, namegr);
                setFuncOnmout ( "onmouseout_"  + namebg, namebg, namegr);
                setFuncOnmdown( "onmousedown_" + namebg, namebg, namegr, "<?php echo $DAYS_BG_URL_PARAMETER ?>", jepoch);
                setFuncOnmup  ( "onmouseup_"   + namebg, namebg, namegr, "<?php echo $DAYS_BG_URL_PARAMETER ?>", jepoch)
                setFuncOnkpres( "onkeypress_"  + namebg, namebg, namegr, "<?php echo $DAYS_BG_URL_PARAMETER ?>", jepoch);
           
                bg.onfocus     = this["onfocus_" + namebg];
                bg.onblur      = this["onblur_"  + namebg];
                bg.onmouseover = this["onmouseover_" + namebg];
                bg.onmouseout  = this["onmouseout_" + namebg];
                bg.onmousedown = this["onmousedown_" + namebg];
                bg.onmouseup   = this["onmouseup_" + namebg];
                bg.onkeypress  = this["onkeypress_" + namebg];
                bg.setAttribute("tabindex", i + 1);
                bg.setAttribute("tabIndex", i + 1);
                bg.tabIndex = i + 1;
             }
          }
      // Initialize Gregorian Kalendar....

          <?php $indexgr = bcsub($periodsgr[2]->startsAtDaysAfterEpoch(), 31);?>
          var indexgr = <?php echo $indexgr;?>;
          var indexbg = 
          <?php echo bcadd($indexgr, bcsub($daysbgFromStartOfCalendarTillJavaEpoch, $daysgrFromStartOfCalendarTillJavaEpoch));?>;
          //var jepochindex = <?php echo bcsub($indexgr, $daysgrFromStartOfCalendarTillJavaEpoch);?>;
          var jepochindex = indexgr;
          var i = 0;
          for (i = 0; i <= (366 + 31); i++) {
             var namebg = "daybg" + (indexbg + i);
             var namegr = "daygr" + (indexgr + i);
             var jepoch = jepochindex + i;

             var bg = document.getElementById(namebg);
             var gr = document.getElementById(namegr);

             if (gr != null) {
                setFuncOnFocus( "onfocus_"     + namegr, namegr, namebg);
                setFuncOnBlur ( "onblur_"      + namegr, namegr, namebg);
                setFuncOnmover( "onmouseover_" + namegr, namegr, namebg);
                setFuncOnmout ( "onmouseout_"  + namegr, namegr, namebg);
                setFuncOnmdown( "onmousedown_" + namegr, namegr, namebg, "<?php echo $DAYS_GR_URL_PARAMETER;?>", jepoch);
                setFuncOnmup  ( "onmouseup_"   + namegr, namegr, namebg, "<?php echo $DAYS_GR_URL_PARAMETER;?>", jepoch);
                setFuncOnkpres( "onkeypress_"  + namegr, namegr, namebg, "<?php echo $DAYS_GR_URL_PARAMETER;?>", jepoch);
           
                gr.onfocus     = this["onfocus_" + namegr];
                gr.onblur      = this["onblur_"  + namegr];
                gr.onmouseover = this["onmouseover_" + namegr];
                gr.onmouseout  = this["onmouseout_" + namegr];
                gr.onmousedown = this["onmousedown_" + namegr];
                gr.onmouseup   = this["onmouseup_" + namegr];
                gr.onkeypress  = this["onkeypress_" + namegr];
                gr.setAttribute("tabindex", i + 1);
                gr.setAttribute("tabIndex", i + 1);
                gr.tabIndex = (366 + 31) + i + 1;
             }
          }
     }
   </script>
</head>
<body class="calendarbody" onload="javascript:initialize();">

<!-- Facebook Like Button JavaScript SDK - START -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Facebook Like Button JavaScript SDK - END -->

<!-- The actual Facebook like and share button START -->
<div class="fb-like" data-href="http://bgkalendar.com/" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
<!-- The actual Facebook like and share button END -->
<a class="forumbtn" href="http://bgkalendar.com/forum">Дискусии</a>
<br/>
<br/>


Тази страница представлява опит за компютърен модел на <a href="kalendar.html">древният български календар</a> и сравнението му със съвременния грегориански календар.
<br/>
<br/>

<div id="bgcalclosed" class="openclosebutton-closed">
   <a class="openclosebutton" onclick="javascript: openclosebutton('bgcalclosed', 'bgcal', 'inline-block');"><div class="openclosebutton">+</div></a>
</div>
<div class="calendartype" id="bgcal" style="margin-right: 1em;">
<a class="openclosebutton" onclick="javascript: openclosebutton('bgcal', 'bgcalclosed', 'block');">
<div class="openclosebutton openclosebutton-position">-</div>
</a>
<center>
<div class="calendartypetitle">
   Древен Български Календар
</div>
</center>
<div>
<nobr>Ден:    <?php echo $daybgformatted;?>,</nobr> 
<nobr>Месец:  <?php echo $periodsbg[1]->getStructure()->getName();?>,</nobr> 
<nobr>Година: <?php echo $yearbgformatted;?></nobr>
&nbsp; &nbsp;
<nobr>
[
<?php echo $daybgformatted.'-'.$monthbgformatted.'-'.$yearbg;?>
&nbsp; &nbsp;
<?php if ($hour != -1 && $minute != -1 && $secund != -1) { ?>
  <?php echo formatMinimumDigits($hour, 2);?>:<?php echo formatMinimumDigits($minute, 2);?>:<?php echo formatMinimumDigits($secund, 2);?>
<?php } ?>
]
</nobr>
&nbsp; &nbsp;

<a class="details" onclick="javascript:showhidedetails('detailsbg');">Детайли</a></div>
<div class="details" id="detailsbg">
   <table>
       <tr>
           <td class="details bold">Ден:</td>
           <td class="details bold"><a class="up" href="?db=<?php echo $daysbg + 1;?>">&#x25B2;</a><a class="down" href="?db=<?php echo $daysbg - 1; ?>">&#x25BC;</a></td>
           <td class="details"><?php echo seqPrefixM($periodsbg[0]->getNumber() + 1);?></td>
           <td class="details">
               <?php if ($daybg == 31 && $monthbg == 12) :?>
                    (Еднажден, Игнажден, Ани-Алем");
               <?php elseif ($daybg == 31 && $monthbg == 6) : ?>
                    (Ени-Джитем)
               <?php else : ?>
                    &nbsp;
               <?php endif; ?>
               <?php $weekdaybg = getBulgarianWeekDay($monthbg+1, $daybg+1);?>
               <?php if ($weekdaybg != 0) : ?>
                    ден <?php echo seqPrefixM($weekdaybg);?> от българската седмица
               <?php endif; ?>
           </td>
       </tr>
       <tr>
           <td class="details bold">Месец:</td>
           <td class="details bold">
               <a class="up" href="?db=<?php echo $daysbg + $periodsbg[1]->getStructure()->getTotalLengthInDays();?>">&#x25B2;</a><a class="down" href="?db=<?php echo $daysbg - $periodsbg[1]->getStructure()->getTotalLengthInDays(); ?>">&#x25BC;</a>
           </td>
           <td class="details" colspan="2"><?php echo "" . seqPrefixM($periodsbg[1]->getNumber() + 1) . " (" . $periodsbg[1]->getStructure()->getName() . ")";?></td>
       </tr>
       <tr>
           <td class="details bold">Година:</td>
           <td class="details bold">
               <a class="up" href="?db=<?php echo $daysbg + $periodsbg[2]->getStructure()->getTotalLengthInDays();?>">&#x25B2;</a><a class="down" href="?db=<?php echo $daysbg - $periodsbg[2]->getStructure()->getTotalLengthInDays(); ?>">&#x25BC;</a>
           </td>
           <td class="details nobr"><?php echo seqPrefixF($periodsbg[2]->getAbsoluteNumber() + 1);?></td>
           <td class="details"><a class="period" href="kalendar.html#12g"><?php echo $YEAR_ANIMALS   [($periodsbg[2]->getAbsoluteNumber()) % 12];?></a>
                (<?php echo $YEAR_ANIMALS_BG[($periodsbg[2]->getAbsoluteNumber()) % 12];?>)<br/>
                <?php echo seqPrefixF($periodsbg[2]->getNumber()+1);?> от началото на Четиригодие<br/>
                <?php $yearbginstaryear = ( ( $periodsbg[2]->getAbsoluteNumber() ) % 60 ) + 1; ?>
                <?php echo seqPrefixF($yearbginstaryear);?> от началото на 60 годишния Звезден Ден
           </td>
       </tr>
   </table>
   <table>
       <tr>
            <td class="details bold"><a href="kalendar.html#4g" class="period">Четиригодие</a>:</td>
            <td class="details detailsleft nobr"><?php echo seqPrefixN($periodsbg[3]->getNumber()+1);?></td>

            <td class="details bold detailsright"><a class="period" href="kalendar.html#1680g">Звезден Месец</a>:</td>
            <td class="details nobr"><?php echo seqPrefixM($periodsbg[6]->getNumber()+1);?></td>
       </tr>
       <tr>
            <td class="details bold"><a class="period" href="kalendar.html#60g">Звезден Ден</a>:</td>
            <td class="details detailsleft nobr"><?php echo seqPrefixM($periodsbg[4]->getNumber()+1);?></td>

            <td class="details bold detailsright"><a class="period" href="kalendar.html#20160g">Звездна Година</a>:</td>
            <td class="details nobr"><?php echo seqPrefixF($periodsbg[7]->getNumber()+1);?></td>
       </tr>
       <tr>
            <td class="details bold"><a class="period" href="kalendar.html#420">Звездна Седмица</a>:</td>
            <td class="details detailsleft nobr"><?php echo seqPrefixF($periodsbg[5]->getNumber()+1);?></td>

            <td class="details bold detailsright"><a class="period" href="kalendar.html#10080000g">Звездна Епоха</a>:</td>
            <td class="details nobr"><?php echo seqPrefixF($periodsbg[8]->getNumber()+1);?></td>
       </tr>
       <?php if (file_exists(__DIR__ . "/infobg/" . $daybgformatted.'-'.$monthbgformatted.'.php')) { ?>
       <tr>
            <td colspan="4">
               <div class="info">
               <?php include(__DIR__ . "/infobg/" . $daybgformatted.'-'.$monthbgformatted.'.php'); ?> 
               </div>
            </td>
       </tr>
       <?php } ?>
   </table>
   <!-- These are the details. -->
</div>
<?php 
   $ibg = $periodsbg[2]->startsAtDaysAfterEpoch();
   $igr = bcsub($ibg, bcsub($daysbgFromStartOfCalendarTillJavaEpoch, $daysgrFromStartOfCalendarTillJavaEpoch));
   $jepochindex = bcsub($ibg, $daysbgFromStartOfCalendarTillJavaEpoch);
   $wday = bcmod($igr, 7);
   $tbg = $daysbgFromStartOfCalendar;
?>
<table border="0" style="margin: 10px; border: 10px;">
   <tr>
       <td class="calendartable yearperiod" rowspan="2">
        <div class="calendarvertical yearperiod">Първо Полугодие</div>
       </td>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Първо Тримесечие</div>
       </td>
       <td>
           <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Първи</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">31</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
           </tr>
       </table>
           </div>
           <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Втори</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
           </tr>
       </table>
           </div>
           <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Трети</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
           </tr>
       </table>
           </div>
       </td>
   </tr>
   <tr>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Второ Тримесечие</div>
       </td>
       <td style="vertical-align: top;">
           <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Четвърти</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">31</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
           </tr>
       </table>
       </div>
       <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Пети</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
           </tr>
       </table>
       </div>
       <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Шести</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
           </tr>
<?php 
$subperiods = ( isset($periodsbg[2]) && $periodsbg[2]->getStructure() != null) ? 
    ( $periodsbg[2]->getStructure()->getSubPeriods() ) : 
    ( null ); 
?>
<?php if ( isset($subperiods[5]) && $subperiods[5]->getTotalLengthIndays()>= 31) : ?>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>" colspan="7">Ден Бехти</td><?php $wday%=7?>
           </tr>
<?php endif ?>
       </table>
       </div>
       </td>
   </tr>
   <tr>
       <td class="calendartable yearperiod" rowspan="2">
        <div class="calendarvertical yearperiod">Второ Полугодие</div>
       </td>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Трето Тримесечие</div>
       </td>
       <td>
           <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Седми</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">31</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
           </tr>
       </table>
       </div>
       <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Осми</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
           </tr>
       </table>
       </div>
       <div class="month">
           <table class="calendartable">
           <tr class="calendartable">
               <td class="calendartable" colspan="7" style="text-align: center;">Месец Девети</td>
           </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
           <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
           </tr>
           <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
           </tr>
       </table>
       </div>
       </td>
   </tr>
   <tr>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Четвърто Тримесечие</div>
       </td>
       <td style="vertical-align: top"> 
         <div class="month">
         <table class="calendartable"> <tr class="calendartable">
           <td class="calendartable" 
                   colspan="7" 
                   style="text-align: center;">
                  Месец Десети
               </td>
         </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">31</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
         </tr>
       </table>
       </div>
       <div class="month">
           <table class="calendartable">
         <tr class="calendartable">
           <td class="calendartable" 
                   colspan="7" 
                   style="text-align: center;">
                 Месец Единайсти
               </td>
         </tr>
           <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
           </tr>
         <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
         </tr>
         <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
         </tr>
       </table>
       </div>
       <div class="month">
           <table class="calendartable">
        <tr class="calendartable">
          <td class="calendartable" colspan="7" style="text-align: center;"> Месец Дванайсти </td>
        </tr>
        <tr class="calendartable">
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">1<sup>-ви</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">2<sup>-ри</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">3<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">4<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">5<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">6<sup>-ти</sup></div></td>
               <td class="calendarweekrow dayofweek"><div class="calendarvertical dayofweek">7<sup>-ми</sup></div></td>
        </tr>
        <tr class="calendartable">
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable"></td>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">1</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">2</td><?php $wday%=7?>
        </tr>
        <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">3</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">4</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">5</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">6</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">7</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">8</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">9</td><?php $wday%=7?>
        </tr>
        <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">10</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">11</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">12</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">13</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">14</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">15</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">16</td><?php $wday%=7?>
        </tr>
        <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">17</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">18</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">19</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">20</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">21</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">22</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">23</td><?php $wday%=7?>
        </tr>
        <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">24</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">25</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">26</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">27</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">28</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">29</td><?php $wday%=7?>
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>">30</td><?php $wday%=7?>
        </tr>
        <tr class="calendartable">
       <td class="calendartable<?php echo getBckGrnd($ibg,$tbg,$wday++)?>" id="daybg<?php echo $ibg++?>" colspan="7">Ден Ени</td><?php $wday%=7?>
        </tr>
       </table>
       </div>
       </td>
   </tr>
</table>
</div>

<!-- ***************************************************************************************************** -->

<div id="grcalclosed" class="openclosebutton-closed">
   <a class="openclosebutton" onclick="javascript: openclosebutton('grcalclosed', 'grcal', 'inline-block');"><div class="openclosebutton">+</div></a>
</div>
<div class="calendartype" id="grcal" style="margin-left: 1em;">
<a class="openclosebutton" onclick="javascript: openclosebutton('grcal', 'grcalclosed', 'block');">
<div class="openclosebutton openclosebutton-position">-</div>
</a>
<center>
<div class="calendartypetitle">
   Съвременен Грегориански Календар
</div>
</center>
<div>
<nobr>Ден: <?php echo formatMinimumDigits($daygr, 2);?>,</nobr>
<nobr>Месец: <?php echo $periodsgr[1]->getStructure()->getName();?>,</nobr> 
<nobr>Година: <?php echo formatMinimumDigits($yeargr, 4);?></nobr>
&nbsp; &nbsp;
<nobr>
[
<?php echo $daygrformatted.'-'.$monthgrformatted.'-'.$yeargrformatted;?>
&nbsp; 
<?php if ($hour != -1 && $minute != -1 && $secund != -1) { ?>
  <?php echo formatMinimumDigits($hour, 2);?>:<?php echo formatMinimumDigits($minute, 2);?>:<?php echo formatMinimumDigits($secund, 2);?>
<?php } ?>
]
</nobr>
&nbsp; &nbsp;

<a class="details" onclick="javascript:showhidedetails('detailsgr');">Детайли</a></div>
<div class="details" id="detailsgr">
   <table>
       <tr>
           <td class="details bold">Ден:</td>
           <td class="details bold">
               <a class="up" href="?dg=<?php echo $daysgr + 1;?>">&#x25B2;</a><a class="down" href="?dg=<?php echo $daysgr - 1; ?>">&#x25BC;</a>
           </td>
           <td class="details"><?php echo seqPrefixM($periodsgr[0]->getNumber() + 1);?></td>
           <td class="details">
               <?php $weekdaygr = $WEEKDAYS[bcmod($daysgrFromStartOfCalendar, '7')];?>
               Ден от седмицата: <?php echo $weekdaygr;?> 
           </td>
       </tr>
       <tr>
           <td class="details bold">Месец:</td>
           <td class="details bold">
               <a class="up" href="?dg=<?php echo $daysgr + $periodsgr[1]->getStructure()->getTotalLengthInDays();?>">&#x25B2;</a><a class="down" href="?dg=<?php echo $daysgr - $periodsgr[1]->getStructure()->getTotalLengthInDays(); ?>">&#x25BC;</a>
           </td>
           <td class="details" colspan="2"><?php echo "" . seqPrefixM($periodsgr[1]->getNumber() + 1) . " (" . $periodsgr[1]->getStructure()->getName() . ")";?></td>
       </tr>
       <tr>
           <td class="details bold">Година:</td>
           <td class="details bold">
               <a class="up" href="?dg=<?php echo $daysgr + $periodsgr[2]->getStructure()->getTotalLengthInDays();?>">&#x25B2;</a><a class="down" href="?dg=<?php echo $daysgr - $periodsgr[2]->getStructure()->getTotalLengthInDays(); ?>">&#x25BC;</a>
           </td>
           <td class="details nobr"><?php echo seqPrefixF($periodsgr[2]->getAbsoluteNumber() + 1);?></td>
           <td class="details">
                <?php echo seqPrefixF($periodsgr[2]->getNumber()+1);?> от началото на Четиригодие<br/>
                <?php $yeargrincentury = ( ( $periodsgr[2]->getAbsoluteNumber() ) % 100 ) + 1; ?>
                <?php echo seqPrefixF($yeargrincentury);?> от началото на Столетие (Век) 
           </td>
       </tr>
       <tr>
            <td class="details bold">Четиригодие:</td>
            <td class="details nobr"><?php echo seqPrefixN($periodsgr[3]->getNumber()+1);?></td>

            <td class="details" colspan="2"> от началото на столетието/века</td>
       </tr>
       <tr>
            <td class="details bold">Столетие/Век:</td>
            <td class="details nobr"><?php echo seqPrefixM($periodsgr[4]->getAbsoluteNumber()+1);?></td>

            <td class="details" colspan="2">
               <?php echo seqPrefixM($periodsgr[4]->getAbsoluteNumber()+1);?> от началото на календара и 
               <br/><?php echo seqPrefixM($periodsgr[4]->getNumber()+1);?> от началото на 400г. период.
            </td>
       </tr>
       <tr>
            <td class="details bold">400г. период:</td>
            <td class="details detailsleft nobr"><?php echo seqPrefixM($periodsgr[5]->getAbsoluteNumber()+1);?></td>

            <td class="details bold detailsright"></td>
            <td class="details"></td>
       </tr>
       <?php if (file_exists(__DIR__ . "/infogr/" . $daygrformatted.'-'.$monthgrformatted.'.php')) { ?>
       <tr>
            <td colspan="4">
               <div class="info">
               <?php include(__DIR__ . "/infogr/" . $daygrformatted.'-'.$monthgrformatted.'.php'); ?> 
               </div>
            </td>
       </tr>
       <?php } ?>
   </table>
   <!-- These are the details. -->
</div>
<?php 

function drawMonth($year, $monthName, $numDays, $startAtDayOfWeek, $indexgr, $tgr) {
    static $WEEKDAYS_SHORT = array(
        "пн", "вт", "ср", "чт", "пт", "сб", "не"
    );
    $sb = "";
    if ($startAtDayOfWeek >=7 ) {
        throw new RuntimeException("Starting day of week cannot be " . $startAtDayOfWeek
              . ". It should be between 0 and 7.");
    }
    if ($startAtDayOfWeek < 0) {
        throw new RuntimeException("Starting day of week cannot be negative (" . $startAtDayOfWeek . ").");
    }
    if ($numDays <= 0) {
        throw new RuntimeException("A month of " . $numDays
              . " days is not allowed. Month should have at least one day.");
    }

    $sb.="<table class=\"calendartable\">";
    $sb.="<tr class=\"calendartable\">";
    $sb.="    <td class=\"calendartable\" colspan=\"7\" style=\"text-align: center;\">";
    $sb.=$monthName . " " . $year;
    $sb.="    </td>";
    $sb.="</tr>";
    $sb.="<tr class=\"calendartable\">";
    for ($i = 0; $i < count($WEEKDAYS_SHORT); $i++) {
        $sb.="<td class=\"calendarweekrow dayofweek dayofweekgr\"><div class=\"calendarvertical dayofweek\">" . $WEEKDAYS_SHORT[$i] . "</div></td>";
    }
    $sb.="</tr>";
    $rows = $numDays + $startAtDayOfWeek;
    $rows = (($rows - ($rows % 7))  / 7) + ($rows % 7 > 0 ? 1 : 0);
    $month = array();

    $dayOfWeek = $startAtDayOfWeek;
    $row = 0;
    for ($i = 1; $i <= $numDays; $i++) {
       if (!isset($month[$row])) {
          $month[$row] = array();
       }
       $month[$row][$dayOfWeek] = "" . $i;
       $dayOfWeek++;
       if ($dayOfWeek >= count($WEEKDAYS_SHORT)) {
           $dayOfWeek = 0;
           $row++;
       }
    }
    for ($row = 0; $row < $rows; $row++) {
       $sb.="<tr class=\"calendartable\">";
       for ($col = 0; $col < count($WEEKDAYS_SHORT); $col++) {

           if (isset($month[$row][$col])) { 
              $sb.="<td class=\"calendartable". getBckGrnd($indexgr,$tgr,$col)."\" id=\"daygr".$indexgr."\">";
              $sb.=$month[$row][$col];
              $sb.="</td>";
              $indexgr++;
           } else {
              $sb.="<td class=\"calendartable\"></td>";
           }
       }
       $sb.="</tr>";
    }
    $sb.="</table>";
    echo $sb;
    return $indexgr;
}
$igr = $periodsgr[2]->startsAtDaysAfterEpoch();
$ibg = bcadd($igr, bcsub($daysbgFromStartOfCalendarTillJavaEpoch, $daysgrFromStartOfCalendarTillJavaEpoch));


$jepochindex = bcsub($igr, $daysgrFromStartOfCalendarTillJavaEpoch);
$tgr = $daysgrFromStartOfCalendar;
$igr = bcsub($igr, '31');
$wday = bcmod($igr, 7);
?>

<table border="0" style="float: left; margin: 10px; border: 10px;">
   <!--
   <tr>
       <td colspan="3" style="vertical-align: top;">
         <div class="month">
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber(), "Декември", 31, $wday, $igr, $tgr);?>
         </div>
       </td>
   </tr>
   -->
   <tr>
       <td class="calendartable yearperiod" rowspan="2">
        <div class="calendarvertical yearperiod">Първо Полугодие</div>
       </td>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Първо Тримесечие</div>
       </td>
       <td style="vertical-align: top">
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Януари", 31, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php
            $wday = bcmod($igr, 7); 
            $februarydays = 28; 
            $subperiods = ( isset($periodsgr[2]) && $periodsgr[2]->getStructure() != null) ?
                ( $periodsgr[2]->getStructure()->getSubPeriods() ) :
                ( null );
            if ( isset($subperiods[1])) {
               $februarydays = $subperiods[1]->getTotalLengthIndays();
            }
            ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Февруари", $februarydays, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Март", 31, $wday, $igr, $tgr);?>
         </div>
       </td>
   </tr>
   <tr>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Второ Тримесечие</div>
       </td>
       <td style="vertical-align: top;">
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Април", 30, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Май", 31, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Юни", 30, $wday, $igr, $tgr);?>
         </div>
       </td>
   </tr>
   <tr>
       <td class="calendartable yearperiod" rowspan="2">
        <div class="calendarvertical yearperiod">Второ Полугодие</div>
       </td>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Трето Тримесечие</div>
       </td>
       <td style="vertical-align: top">
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Юли", 31, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Август", 31, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Септември", 30, $wday, $igr, $tgr);?>
         </div>
       </td>
   </tr>
   <tr>
       <td class="calendartable yearperiod">
        <div class="calendarvertical yearperiod">Четвърто Тримесечие</div>
       </td>
       <td style="vertical-align: top">
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Октомври", 31, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Ноември", 30, $wday, $igr, $tgr);?>
         </div>
         <div class="month">
           <?php $wday = bcmod($igr, 7); ?>
           <?php $igr = drawMonth($periodsgr[2]->getAbsoluteNumber()+1, "Декември", 31, $wday, $igr, $tgr);?>
         </div>
       </td>
   </tr>
</table>
</div>

<div class="clearfloat"/>
<hr/>
Изходен код и документация на английски: <a href="https://github.com/ynedelchev/bgkalendar/">от гитхъб.</a>
<br/>
<!-- Tracker code start -->
<div id="eXTReMe"><a href="http://extremetracking.com/open?login=yordan">
<img src="http://t1.extreme-dm.com/i.gif" style="border: 0;"
height="38" width="41" id="EXim" alt="eXTReMe Tracker" /></a>
<script type="text/javascript"><!--
EXref="";top.document.referrer?EXref=top.document.referrer:EXref=document.referrer;//-->
</script><script type="text/javascript"><!--
var EXlogin='yordan' // Login
var EXvsrv='s9' // VServer
EXs=screen;EXw=EXs.width;navigator.appName!="Netscape"?
EXb=EXs.colorDepth:EXb=EXs.pixelDepth;EXsrc="src";
navigator.javaEnabled()==1?EXjv="y":EXjv="n";
EXd=document;EXw?"":EXw="na";EXb?"":EXb="na";
EXref?EXref=EXref:EXref=EXd.referrer;
EXd.write("<img "+EXsrc+"=http://e0.extreme-dm.com",
"/"+EXvsrv+".g?login="+EXlogin+"&amp;",
"jv="+EXjv+"&amp;j=y&amp;srw="+EXw+"&amp;srb="+EXb+"&amp;",
"l="+escape(EXref)+" height=1 width=1>");//-->
</script><noscript><div id="neXTReMe"><img height="1" width="1" alt=""
src="http://e0.extreme-dm.com/s9.g?login=yordan&amp;j=n&amp;jv=n" />
</div></noscript></div>
<!-- Tracker code end-->




</body>
</html>
