<?php
require_once(__DIR__.'/includes.php');
$monthsgrnames = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
$monthsbgnames = array("Месец Първи", "Месец Втори", "Месец Трети", "Месец Четвърти", "Месец Пети", "Месец Шести", "Месец Седми", "Месец Осми", "Месец Девети", "Месец Десети", "Месец Едuнайсти", "Месец Дванайсти");
if ($lang == 'en') {
  $monthsgrnames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $monthsbgnames = array("Month One", "Month Two", "Month Tree", "Month Four", "Month Five", "MOnth Six", "Month Seven", "Month Eight", "Month Nine", "Month Ten", "Month Eleven", "Month Twelve");
} else if ($lang == 'de') {
  $monthsgrnames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $monthsbgnames = array("Month One", "Month Two", "Month Tree", "Month Four", "Month Five", "MOnth Six", "Month Seven", "Month Eight", "Month Nine", "Month Ten", "Month Eleven", "Month Twelve");
} else if ($lang == 'ru') {
  $monthsgrnames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $monthsbgnames = array("Month One", "Month Two", "Month Tree", "Month Four", "Month Five", "MOnth Six", "Month Seven", "Month Eight", "Month Nine", "Month Ten", "Month Eleven", "Month Twelve");
} 

$grbgdiff = 1 +
        bcsub(
             bcsub($periodsgr[2]->startsAtDaysAfterEpoch(),
                   $gr->startOfCalendarInDaysBeforeJavaEpoch()
             ),
             bcsub($periodsbg[2]->startsAtDaysAfterEpoch(),
                   $bg->startOfCalendarInDaysBeforeJavaEpoch()
             )
         );
$curdaybg = bcsub($periodsbg[0]->startsAtDaysAfterEpoch(), $periodsbg[2]->startsAtDaysAfterEpoch());
$monthsgrdays  = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);  
$rad = 500;
$strtx = 35;
$strty = 40;
$grbegin = $grbgdiff;
$year = 7522;
$yeargr = 2017;
$leap = $isleapbg ? 1 : 0;
$leapgr = $isleapgr ? 1 : 0;
$monthsgrdays[1] = $monthsgrdays[1] + $leapgr;

$svgwidth  =  $strtx*2 + $rad*2;
$svgheight =  $strty*2 + $rad*2; 
?><svg width="<?php echo $svgwidth;?>" height="<?php echo $svgheight;?>" viewBox="0 0 <?php echo $svgwidth;?> <?php echo $svgheight;?>" <?php if ($setfonts) echo 'style="margin: auto;"'; ?>
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:cc="http://creativecommons.org/ns#"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:svg="http://www.w3.org/2000/svg"
   xmlns="http://www.w3.org/2000/svg"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   id="svg"
   version="1.1"
   sodipodi:docname="cyrcle-bgkalendar.svg"
>
  <circle cx="<?php echo $strtx + $rad;?>" cy="<?php echo $strty + $rad;?>" r="<?php echo $rad;?>" stroke="green" stroke-width="5" fill="none" />
<?php if ($setfonts) : ?> 
<defs>
  <style>
    /* <![CDATA[ *//* <![CDATA[ */
    @font-face {
        font-family: notos;
        src: url('fonts/notoserif-regular.ttf');
    }
    @font-face {
        font-family: "Harlow Solid Italic";
        src: url('fonts/harlow.ttf');
    }
    text {
        font-family: notos;
        font-weight: bold;
    }
    /* ]]> */
 </style>
</defs>
<?php endif ?>
  <!-- Month One Begin -->
<?php
  $color = "green";
  $end = "";
  $begin = "";
  $month = 1;
  $day = 0;

  $colorgr = "green";
  $monthgr = -1;
  $daygr = 32-$grbegin;
  
  $i = 0;
  for (; $i < 365 + $leap; $i++) {
    $color = "green"; 
    $colorgr = "green";

    if ($i+1 == $grbegin) {
      $monthgr = 0; 
      $daygr = 1;
      $colorgr = "blue";
    } else if ($i+1 > $grbegin) {
      if ($monthgr >=0 && $monthgr < 12) {
        $daygr ++;
        if ($daygr > $monthsgrdays[$monthgr]) {
          $monthgr++;
          $daygr = 1;
          $colorgr = "blue";
        } 
        if ($daygr == $monthsgrdays[$monthgr]) {
          //$colorgr = "blue";
        }
      } else {
        $monthgr = -1;
      }
    } else {
      $daygr++;
    }  

    $d = (360.0 * $i ) / (365 + $leap); // long double
    $end = "";
    $begin = "";
    
    $day++;

    if ($i == 31) {
       $end="<!-- Month One End   -->\n\n";
       $begin="<!-- Month Two Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 61) {
       $end="<!-- Month Two  End   -->\n\n";
       $begin="<!-- Month Tree Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 91) {
       $end="<!-- Month Tree End   -->\n\n";
       $begin="<!-- Month Four Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 122) {
       $end="<!-- Month Four End   -->\n\n";
       $begin="<!-- Month Five Begin -->\n";;
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 152) {
       $end="<!-- Month Five End   -->\n\n";
       $begin="<!-- Month Six  Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 182) {
       $end="<!-- Month Six   End   -->\n";
       $begin="";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 182 + $leap) {
       $begin="\n<!-- Month Seven Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 213 + $leap) {
       $end="<!-- Month Seven End   -->\n\n";
       $begin="<!-- Month Eight Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 243 + $leap) {
       $end="<!-- Month Eight End   -->\n\n";
       $begin="<!-- Month Nine  Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 273 + $leap) {
       $end="<!-- Month Nine End   -->\n\n";
       $begin="<!-- Month Ten  Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 304 + $leap) {
       $end="<!-- Month Ten     End   -->\n\n";
       $begin="<!-- Month Eleven  Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 334 + $leap) {
       $end="<!-- Month Eleven End   -->\n\n";
       $begin="<!-- Month Twelve Begin -->\n";
       $color = "blue";
       $month++; $day= 1;
    }
    if ($i == 364 + $leap) {
       $end="<!-- Month Twelve End   -->\n\n";
       $begin="";
       $color = "blue";
       $month++; $day= 1;
    }
    if (($month == 7) || ($month == 14)) {
       $day = 31;
    } 
?>


<!-- <?php echo $i+1;?> <?php echo $year;?>-<?php echo $month;?>-<?php echo $day;?>
<?php
    if ($monthgr >= 0 && $daygr > 0) { 
      echo "   ".$yeargr . '-' . ($monthgr + 1) . '-' .$daygr;
    }
?>
 -->
<?php
    $cntr = "".($strtx+$rad).",".($strty+$rad);    

    $ybg = $strty + 15;
    if ($i == 0 || ( ! is_null($color) && $color[0] == 'b')) { $ybg = $starty + 160;  }
    echo "<text x=\"".($strtx+$rad + 1)."\" y=\"".($strty+10)."\" fill=\"black\" transform=\"rotate($d,$cntr)\" style=\"font: 0.4em times\">$day</text>\n";
    echo "<line x1=\"".($strtx+$rad)."\" y1=\"$ybg\" x2=\"".($strtx+$rad)."\" y2=\"$strty\" stroke=\"$color\" stroke-width=\"1\" transform=\"rotate($d, $cntr)\" />\n";

    $ygr = $strty - 10;
    if (! is_null($colorgr) && $colorgr[0] == 'b') { $ygr = $strty - 40;  }
    echo "<text x=\"".($strtx+$rad + 1)."\" y=\"".($strty+10)."\" fill=\"black\" transform=\"rotate($d,$cntr)\" style=\"font: 0.4em times\">$day</text>\n";
    if ($daygr > 0) { 
      echo "<text x=\"".($strtx + $rad + 1)."\" y=\"".($strty-5)."\" fill=\"black\" transform=\"rotate($d,$cntr)\" style=\"font: 0.4em times\">$daygr</text>";
      echo "<line x1=\"".($strtx+$rad)."\" y1=\"$strty\" x2=\"".($strtx+$rad)."\" y2=\"$ygr\" stroke=\"$colorgr\" stroke-width=\"1\" transform=\"rotate($d, $cntr)\" />\n";
    }
    echo $end;
    echo $begin;
  }


   $d = (360 * $curdaybg) / (365 + $leap) + 0.5;
   echo "<line x1=\"".($strtx+$rad)."\"    y1=\"".($strty+120)."\" ". 
               "x2=\"".($strtx+$rad)."\"    y2=\"".($strty+26)."\" ". 
               "stroke=\"red\" stroke-width=\"5\" transform=\"rotate($d,$cntr)\" stroke-linecap=\"round\"/>\n";
   echo "<line x1=\"".($strtx+$rad)."\"    y1=\"".($strty+26)."\" ".  
               "x2=\"".($strtx+$rad-10)."\" y2=\"".($strty+36)."\" ". 
               "stroke=\"red\" stroke-width=\"5\" transform=\"rotate($d,$cntr)\" stroke-linecap=\"round\"/>\n";
   echo "<line x1=\"".($strtx+$rad)."\"    y1=\"".($strty+26)."\" ".  
               "x2=\"".($strtx+$rad+10)."\" y2=\"".($strty+36)."\" ". 
               "stroke=\"red\" stroke-width=\"5\" transform=\"rotate($d,$cntr)\" stroke-linecap=\"round\"/>\n";

  for ($i =0; $i < 12; $i++) {
    $xgr = $strtx + $rad - (strlen($monthsgrnames[$i]) * 5) / 2;
    $xbg = $strtx + $rad - (strlen($monthsbgnames[$i]) * 5) / 2;
    $dgr = ( (360 * $i) / 12 ) + ((360 * $grbegin) / (365+$leapgr)) + (360 / 24);
    $dbg = ( (360 * $i) / 12 ) + (360 / 24);
    echo "<text x=\"$xgr\" y=\"".($strty-20)."\" fill=\"black\" transform=\"rotate($dgr,$cntr)\" $font>$monthsgrnames[$i]</text>\n";
    echo "<text x=\"$xbg\" y=\"".($strty+55)."\" fill=\"black\" transform=\"rotate($dbg,$cntr)\" $font>$monthsbgnames[$i]</text>\n";
  }


?>

  <g transform="translate(<?php echo $strtx + $rad - 380;?>,<?php echo $strty + $rad - 374;?>)">
    <?php include(__DIR__.'/images/cyrcle-rozeta.svg');?>
  </g>   
  <!--
  <g transform="rotate(11.0, 128, 128) translate(226, 82)">
    <?php include(__DIR__.'/images/cyrcle-rozeta.svg');?>
  </g>   
  -->
   
</svg>
