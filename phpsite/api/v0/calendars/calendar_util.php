<?php
$PHP_HOME = dirname(dirname(dirname(__DIR__)));
require_once($PHP_HOME.'/leto/api/Leto.php');
require_once($PHP_HOME.'/leto/api/LetoException.php');
require_once($PHP_HOME.'/leto/api/LetoExceptionUnrecoverable.php');
require_once($PHP_HOME.'/leto/api/LetoPeriod.php');
require_once($PHP_HOME.'/leto/api/LetoPeriodStructure.php');
require_once($PHP_HOME.'/leto/api/LetoPeriodType.php');
require_once($PHP_HOME.'/leto/base/LetoBase.php');
require_once($PHP_HOME.'/leto/base/LetoCorrectnessChecks.php');
require_once($PHP_HOME.'/leto/base/LetoPeriodBean.php');
require_once($PHP_HOME.'/leto/base/LetoPeriodStructureBean.php');
require_once($PHP_HOME.'/leto/base/LetoPeriodTypeBase.php');
require_once($PHP_HOME.'/leto/base/LetoPeriodTypeBean.php');
require_once($PHP_HOME.'/leto/impl/bulgarian/LetoBulgarianMonth.php');
require_once($PHP_HOME.'/leto/impl/bulgarian/LetoBulgarian.php');
require_once($PHP_HOME.'/leto/impl/gregorian/LetoGregorianMonth.php');
require_once($PHP_HOME.'/leto/impl/gregorian/LetoGregorian.php');
require_once($PHP_HOME.'/leto/impl/julian/LetoJulian.php');
require_once($PHP_HOME.'/leto/impl/generic/LetoGeneric.php');

function calendar_to_json($calendar, $name, $description) {
    
  $types = array();
  $calendarTypes = $calendar->getCalendarPeriodTypes();
  $calTypes = $calendar->getCalendarPeriodTypes();
  foreach ($calendarTypes as $calendarType) {
    $calendarStructures = $calendarType->getPossibleStructures();
    $structures = array();
    foreach ($calendarStructures as $calendarStructure) {
      $calendarSubPeriods = $calendarStructure->getSubPeriods();
      $periods = array();
      foreach ($calendarSubPeriods as $calendarSubPeriod) {
        array_push($periods, array(
            'name' => $calendarSubPeriod->getName(),
            'days' => $calendarSubPeriod->getTotalLengthInDays()    
        ));
      }
      $lengths = array();
      foreach($calTypes as $calType) {
         $length = $calendarStructure->getTotalLengthInPeriodTypes($calType);
         if ($length != null && $length > 0) {
           $lengths[$calType->getName()] = (int)$length; 
         } 
      }

      array_push($structures, array(
         'name'    => $calendarStructure->getName(),
         'days'    => $calendarStructure->getTotalLengthInDays(), 
         'length'  => $lengths, 
         'periods' => $periods,
      ));
    } 
    array_push($types, array(
       'name'        => $calendarType->getName(),
       'description' => $calendarType->getDescription(),
       'structures'  => $structures,
    ));
  }
  $result = array(
     'name'    => $name,
     'description' => $description,
     'startInDaysBeforeUnixEpoch' => $calendar->startOfCalendarInDaysBeforeJavaEpoch(),
     'periods' => $types 
  );
  foreach($calendarTypes as $calendarType) {
    foreach($calendarType->getPossibleStructures() as $calendarStructure) {
    }
  }
   
  return $result;

}
?>
