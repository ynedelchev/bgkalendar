<?php require_once('includes.php'); ?>
<div class="toptitle"><span class="toptitle"><?php tr('Българският Календар', 'The Bulgarian Calendar', 'Der Bulgarisch Kalender', 'Болгарский Календарь')?></span>
<style>
   ul.vmenu {
      display: none;
      position: absolute;
      z-index: 1000;         // Put it on top of everything
      list-style-type: none; // Remove the bullets in front of a list item.
      margin-top: 0px;
      -webkit-margin-before: 0px;
      -webkit-margin-after: 0px;
      padding: 0;
      background-color: #f1f1f1;
      border: 1px solid blue;
      border-bottom-left-radius: 1em;
      border-bottom-right-radius: 1em;
      overflow: auto;
   }
   
   
   ul.vmenu a {
      display: block;
      text-decoration: none;   // Remove underlining of links
      background-color: rgba(230,230,230, 1);
      color: black;
      padding: 7px 3em;       // vertical horizontal
   }
   ul.vmenu li:last-child a:hover {
     border-bottom-left-radius: 1em;
     border-bottom-right-radius: 1em;
   }
   ul.vmenu a:hover {
      color: rgba(230,230,230, 1);
      background-color: blue;
      font-weight: bold;
   }
   ul.vmenu li a.header {
      pointer-events: none;
      cursor: default;
      color: rgba(230,230,230, 1);
      background-color: darkblue;
      font-weight: bold;
   }

   /* ================================================================================= */
 
   ul.menu {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: rgba(230,230,230, 1);
   }

   ul.menu li {
     float: left;
   }

   ul.menu li a {
     display: block;
     color: black;
     text-align: center;
     padding: 14px 16px;
     text-decoration: none;
   }

   ul.menu li a:hover {
     color: rgba(230, 230, 230, 1);
     background-color: blue;
     font-weight: bold;
   }   

   ul.menu li a.active {
     color: rgba(230, 230, 230, 1);
     background-color: darkblue;
     font-weight: bold;
   }

</style>
<ul class="menu">
  <li><a sub-menu="sm-intro"   href="#"><?php tr('Начало', 'Home', 'Home', 'Начало')?></a></li>
  <li><a sub-menu="sm-info"    href="#"><?php tr('Информация', 'Information', '', '')?></a></li>
  <li><a sub-menu="sm-forum"   href="forum"><?php tr('Дискусии', 'Forum', '', '')?></a></li>
  <li><a sub-menu="sm-other"   href="#"><?php tr('Други', 'Other', '', '')?></a></li>
  <li><a sub-menu="sm-contact" href="#"><?php tr('За нас', 'About us', '', '')?></a></li>
</ul>
<ul class="vmenu" id="sm-intro">
  <li><a class="header"><?php tr('Начало', 'Home', '', '')?></a></li>
  <li><a href="index.php#cyrcle-bgkalendar"><?php tr('Кръгов календар', 'Cyrcle calendar', '', '')?></a></li>
</ul>
<ul class="vmenu" id="sm-info">
  <li><a class="header"><?php tr('Информация', 'Information', '', '')?></a></li>
  <li><a href="kalendar-<?php tr('bg', 'en', 'de', 'ru');?>.php?lang=<?php tr('bg', 'en', 'de', 'ru');?>"><?php tr('За календара', 'About the calendar', '', '')?></a></li>
  <li><a href="imennik-<?php tr('bg', 'en', 'de', 'ru');?>.php?lang=<?php tr('bg', 'en', 'de', 'ru');?>"><?php tr('Източници', 'Sources of information', '', '')?></a></li>
</ul>
<ul class="vmenu" id="sm-other">
  <li><a class="header"><?php tr('Други', 'Other', '', '')?></a></li>
  <li><a href="kupuлuцa-<?php echo $lang;?>.php?lang=<?php tr('bg', 'en', 'de', 'ru');?>"><?php tr('За българската кирилица', 'About the Bulgarian cyrillic', '', '')?></a></li>
  <li><a href="papercalendar/2017/index.php?lang=<?php tr('bg', 'en', 'de', 'ru');?>"><?php tr('Свали версия за разпечатване 7522/2017', 'Download printable version 7522/2017', '', '')?></a></li>
  <li><a href="papercalendar/2018"><?php tr('Свали версия за разпечатване 7523/2018', 'Download printable version 7523/2018', '', '')?></a></li>
</ul>
<ul class="vmenu" id="sm-contact">
  <li><a class="header"><?php tr('За нас', 'About us', 'Fur wir', 'Для нас')?></a></li>
  <li><a href="gapu.php?lang=<?php echo $lang;?>"><?php tr('Направи дарение', 'Make a donation', '', '')?></a></li>
</ul>
<span style="clear: both;">
<script>
  var visibleMenu = null;
  var visibleSubMenu = null;
  
  function getSubmenuElement(eventObj) {
     if (eventObj == null || eventObj.target == null) {
       return null;
     } 
     var subMenuId = eventObj.target.getAttribute("sub-menu");
     if (subMenuId == null) {
       return null;
     } 
     var subMenu = document.getElementById(subMenuId);
     return subMenu;
  } 
  function openSubmenu() {
     if (visibleMenu != null && visibleMenu != event.target) {
       visibleMenu.classList.remove("active");
     } 
     visibleMenu = event.target;
     visibleMenu.classList.add("active");
     var subMenu = getSubmenuElement(event);
     if (subMenu == null) {
       return;
     } 
     event.preventDefault();
     if (visibleSubMenu != null) {
       visibleSubMenu.style.display = 'none';
     } 
     if (visibleSubMenu != subMenu) {
       var rect = event.target.getBoundingClientRect();
       console.log(rect.top, rect.right, rect.bottom, rect.left);
       subMenu.style.position = "absolute";
       subMenu.style.left = (rect.left-8) + "px";
       subMenu.style.top  = (rect.bottom-8)  + "px";
       subMenu.style.display = 'block';
       visibleSubMenu = subMenu;
     } else {
       visibleMenu.classList.remove("active");
       visibleSubMenu = null;
       visibleMenu = null;
     } 
  } 
  function checkIfMenuToBeClosed() {
    if (visibleSubMenu == null || visibleMenu == null) {
      return;
    }
    var  outsideMenu = false;
    var  outsideSubMenu = false;
    var rect = visibleSubMenu.getBoundingClientRect();
    var x = event.pageX;
    var y = event.pageY;
    console.log(x, y);
    if (x < rect.left || x > rect.right || y < rect.top || y > rect.bottom) {
      outsideSubMenu = true;
    } 
    var rect = visibleMenu.getBoundingClientRect();
    if (x < rect.left || x > rect.right || y < rect.top || y > rect.bottom) {
      outsideMenu = true;
    } 
    if (outsideMenu && outsideSubMenu) {
      visibleMenu.classList.remove("active");
      visibleSubMenu.style.display = 'none';
      visibleSubMenu = null;
      visibleMenu = null;
    } 
  }
  function assignMenuAction(elements) {
     if (elements == null && elements.lenght <= 0) {
       return;
     } 
     for (var index in elements) {
       if (elements[index]["getAttribute"] == null) {
         continue;
       } 
       var subMenu = elements[index].getAttribute('sub-menu');  
       if (subMenu == null) {
          assignMenuAction(elements[index].childNodes);
       } else {
         elements[index].addEventListener("click", openSubmenu);
       } 
     }
  }
  var menues = document.getElementsByClassName("menu");
  assignMenuAction(menues);
  document.addEventListener("click", checkIfMenuToBeClosed);
  
</script>
