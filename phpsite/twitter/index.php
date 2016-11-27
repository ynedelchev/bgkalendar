<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

$oauth_access_token        = isset($_REQUEST['oauth_access_token'])        ? $_REQUEST['oauth_access_token']        : '';
$oauth_access_token_secret = isset($_REQUEST['oauth_access_token_secret']) ? $_REQUEST['oauth_access_token_secret'] : '';  
$consumer_key              = isset($_REQUEST['consumer_key'])              ? $_REQUEST['consumer_key']              : '';
$consumer_secret           = isset($_REQUEST['consumer_secret'])           ? $_REQUEST['consumer_secret']           : '';

if ($oauth_access_token == '') {
  http_response_code(400);
  header('Content-Type: application/json');
  header('X-Reason: Missing oauth_access_token parameter.');
  $obj = array('code'=>400, 
               'reason'=>'Missing oauth_access_token parameter.', 
               'suggestion'=>'Please provide parameter oauth_access_token as a GET or POST parameter.',
               'value'=>"Go to 'https://dev.twitter.com', then 'My Apps', then select your application, then 'Keys and Access Tokens', and  then 'Your Access Token', and use the value of the field 'Access Token'.");
  echo json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR)."\n";
  exit(0);
}
if ($oauth_access_token_secret == '') {
  http_response_code(400);
  header('Content-Type: application/json');
  header('X-Reason: Missing oauth_access_token_secret parameter.');
  $obj = array('code'=>400, 
               'reason'=>'Missing oauth_access_token_secret parameter.', 
               'suggestion'=>'Please provide parameter oauth_access_token_secret as a GET or POST parameter.',
               'value'=>"Go to 'https://dev.twitter.com', then 'My Apps', then select your application, then 'Keys and Access Tokens', and  then 'Your Access Token', and use the value of the field 'Access Token Secret'.");
  echo json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR)."\n";
  exit(0);
}
if ($consumer_key == '') {
  http_response_code(400);
  header('Content-Type: application/json');
  header('X-Reason: Missing consumer_key parameter.');
  $obj = array('code'=>400, 
               'reason'=>'Missing consumer_key parameter.', 
               'suggestion'=>'Please provide parameter consumer_key as a GET or POST parameter.',
               'value'=>"Go to 'https://dev.twitter.com', then 'My Apps', then select your application, then 'Keys and Access Tokens', and  then 'Application Settings', and use the value of the field 'Consumer Key (API Key)'.");
  echo json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR)."\n";
  exit(0);
}
if ($consumer_secret == '') {
  http_response_code(400);
  header('Content-Type: application/json');
  header('X-Reason: Missing consumer_secret parameter.');
  $obj = array('code'=>400, 
               'reason'=>'Missing consumer_secret parameter.', 
               'suggestion'=>'Please provide parameter consumer_secret as a GET or POST parameter.',
               'value'=>"Go to 'https://dev.twitter.com', then 'My Apps', then select your application, then 'Keys and Access Tokens', and  then 'Application Settings', and use the value of the field 'Consumer Secret (API Secret)'.");
  echo json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR)."\n";
  exit(0);
}
/* MESSAGE start */
require_once(dirname(__DIR__) . "/leto/api/Leto.php");
require_once(dirname(__DIR__) . "/leto/api/LetoException.php");
require_once(dirname(__DIR__) . "/leto/api/LetoExceptionUnrecoverable.php");
require_once(dirname(__DIR__) . "/leto/api/LetoPeriod.php");
require_once(dirname(__DIR__) . "/leto/api/LetoPeriodStructure.php");
require_once(dirname(__DIR__) . "/leto/api/LetoPeriodType.php");
require_once(dirname(__DIR__) . "/leto/base/LetoBase.php");
require_once(dirname(__DIR__) . "/leto/base/LetoCorrectnessChecks.php");
require_once(dirname(__DIR__) . "/leto/base/LetoPeriodBean.php");
require_once(dirname(__DIR__) . "/leto/base/LetoPeriodStructureBean.php");
require_once(dirname(__DIR__) . "/leto/base/LetoPeriodTypeBase.php");
require_once(dirname(__DIR__) . "/leto/base/LetoPeriodTypeBean.php");
require_once(dirname(__DIR__) . "/leto/impl/bulgarian/LetoBulgarianMonth.php");
require_once(dirname(__DIR__) . "/leto/impl/bulgarian/LetoBulgarian.php");
require_once(dirname(__DIR__) . "/leto/impl/gregorian/LetoGregorianMonth.php");
require_once(dirname(__DIR__) . "/leto/impl/gregorian/LetoGregorian.php");

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
$daysbgFromStartOfCalendar = null;
$daysgrFromStartOfCalendar = null;
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
   $dailysavingCorrection = '0';//(1L * 60L * 60L * 1000L); // One hour ahead of usual winter time. 0 - means winter time.

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

} 
$periodsbg = $bg->calculateCalendarPeriods($daysbgFromStartOfCalendar);
$periodsgr = $gr->calculateCalendarPeriods($daysgrFromStartOfCalendar);

if ($periodsbg == null || $periodsgr == null) {
  http_response_code(500);
  header('Content-Type: application/json');
  header('X-Reason: Cannot calculate current date because of unknown reason');
  $obj = array('code'=>400, 
               'reason'=>'Cannot calculate current date because of unknown reason.', 
               'suggestion'=>'Please contact admin@bgkalendar.com for further troubleshooting.');
  echo json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR)."\n";
  exit(0);
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
     . formatMinimumDigits($yearbg,4).']';
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

$message = 'Днес е '.formatMinimumDigits($daybg, 2) . "-" . formatMinimumDigits($monthbg, 2) . "-"
     . formatMinimumDigits($yearbg,4).' по Древния Български календар, и съответства на '.$daygrformatted.'-'.$monthgrformatted.'-'.$yeargrformatted.' по Грегорианския календар.'."\n\n\n".'http://bgkalendar.com/?dg='.$daysgr;

/* MESSAGE end */

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => $oauth_access_token,
    'oauth_access_token_secret' => $oauth_access_token_secret,
    'consumer_key' => $consumer_key,
    'consumer_secret' => $consumer_secret 
);

$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';
$postfields = array(
    'status' => $message 
);
$twitter = new TwitterAPIExchange($settings);
if ($twitter == null) {
  http_response_code(500);
  header('Content-Type: application/json');
  header('X-Reason: Cannot create Twitter object.');
  $obj = array('code'=>500, 
               'reason'=>'Cannot create Twitter object', 
               'suggestion'=>'Contact admin@bgkalendar.com for additional troubleshooting.');
  echo json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR)."\n";
  exit(0);
}
http_response_code(200);
header('Content-Type: text/plain');
header('X-Reason: SUCCESS');
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
echo "\r\n";
