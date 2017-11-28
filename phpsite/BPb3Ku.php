<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<?php require_once('includes.php'); ?>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <link rel="stylesheet" type="text/css" href="navigation.css" /> 
   <link rel="stylesheet" type="text/css" href="bgkalendar.css" /> 
   <title><?php tr('Връзки', 'Links', 'Links', 'Връзки');?></title>
   <style>
   a.linkitem {
     text-decoration: none;
   }
   a.linkitem:hover {
     color: rgba(0,0,255,1.0);
   }
   a.linkitem div :hover {
     color: rgba(0,0,255,1.0);
   }
   a.linkitem div {
     float: left;
     text-align: center;
     margin-right: 1em;
     margin-bottom: 1em;
     width: 200px;
     height: 250px;
     border-radius: 7px;
     border: 1px solid rgba(100, 100, 255, 1.0);
   }
   a.linkitem div img {
     margin: 7px;
     box-shadow: 4px 4px 8px 0 rgba(0, 0, 0, 0.2), -4px -4px 8px 0 rgba(0, 0, 0, 0.19);
   }
   </style>
</head>
<body class="calendarbody">
<?php include('navigation.php');?>
<h2><?php tr('Връзки', 'Links', 'Hyperlinks', 'Ссылки');?></h2>

<a href="links/BG_KALENDAR.pdf" class="linkitem">
<div class="linkitem">
  <img src="links/BG_KALENDAR-icon.png"/><br/>
  <?php tr('Българският Календар', 'The Bulgarian Calendar', 'Der Bulgarisch Kalender', 'Болгарский Календарь');?>
  <!-- http://strannik.bg/storage/tinybrowser/upload/BG_KALENDAR.pdf -->
</div>
</a>

<a href="http://historybg.info/%D0%B4%D1%80%D0%B5%D0%B2%D0%B5%D0%BD-%D0%B1%D1%8A%D0%BB%D0%B3%D0%B0%D1%80%D1%81%D0%BA%D0%B8-%D0%BA%D0%B0%D0%BB%D0%B5%D0%BD%D0%B4%D0%B0%D1%80/" class="linkitem">
<div class="linkitem">
  <img src="links/historybg.info.png"/><br/>
  <?php tr('ДРЕВЕН БЪЛГАРСКИ КАЛЕНДАР', 'ANCIENT BULGARIAN CALENDAR', 'DER ANTIK BULGARISCHER KALENDAR', 'ДРЕВНИЙ БОЛГАРСКИЙ КАЛЕНДАРЬ');?> 
</div>
</a>

<a href="http://www.bghistory.info/category/%d0%b4%d1%80%d0%b5%d0%b2%d0%bd%d0%b8%d1%82%d0%b5-%d0%b1%d1%8a%d0%bb%d0%b3%d0%b0%d1%80%d0%b8/%d0%b4%d1%80%d0%b5%d0%b2%d0%bd%d0%be%d0%b1%d1%8a%d0%bb%d0%b3%d0%b0%d1%80%d1%81%d0%ba%d0%b8%d1%8f%d1%82-%d0%ba%d0%b0%d0%bb%d0%b5%d0%bd%d0%b4%d0%b0%d1%80/" class="linkitem">
<div class="linkitem">
  <img src="links/dilyan.ivanov.rozeta.png"/><br/>
  <?php tr('БЪЛГАРСКА ИСТОРИЯ - Древнобългарският календар', 'BULGARIAN HISTORY - The Ancient Bulgarian Calendar', 'BULGARISCHE GESCHICHTE - Der alte Bulgarische Kalender', 'ИСТОРИЯ БОЛГАРИИ - Древний болгарский календарь');?>
</div>
</a>

<a href="http://www.academia.edu/30665934/%D0%9A%D0%B0%D0%BB%D0%B5%D0%BD%D0%B4%D0%B0%D1%80%D1%8A%D1%82_%D0%BD%D0%B0_%D0%B4%D1%80%D0%B5%D0%B2%D0%BD%D0%B8%D1%82%D0%B5_%D0%B1%D1%8A%D0%BB%D0%B3%D0%B0%D1%80%D0%B8_%D0%B8_%D0%B4%D1%80%D0%B5%D0%B2%D0%BD%D0%B8%D1%82%D0%B5_%D1%81%D0%BA%D0%B0%D0%BB%D0%BD%D0%B8_%D0%BE%D0%B1%D1%81%D0%B5%D1%80%D0%B2%D0%B0%D1%82%D0%BE%D1%80%D0%B8%D0%B8_%D0%B2_%D0%B4%D0%BD%D0%B5%D1%88%D0%BD%D0%B8%D1%82%D0%B5_%D0%B1%D1%8A%D0%BB%D0%B3%D0%B0%D1%80%D1%81%D0%BA%D0%B8_%D0%B7%D0%B5%D0%BC%D0%B8._%D0%AF._%D0%99._%D0%A8%D0%BE%D0%BF%D0%BE%D0%B2_Megalithic_monuments_in_the_Western_Rhodopes_and_their_possible_connection_with_the_calendar_system_of_ancient_Bulgarians_Y._Shopov" class="linkitem">
<div class="linkitem">
  <img src="links/shopov.png"/><br/>
  <?php tr('Календарът на древните българи... - Я. Шопов', 'The calendar of the ancient Bulgarians - Y. Shopov', 'Der Kalender der alten Bulgaren - Y. Shopov', 'Календарь древних болгар - Я. Шопов');?>
  <!-- http://strannik.bg/storage/tinybrowser/upload/BG_KALENDAR.pdf -->
</div>
</a>

<a href="http://protobulgarians.com/Kalendar%20na%20prabaalgarite.htm" class="linkitem">
<div class="linkitem">
  <img src="links/Kalendarat-na-prabalgarite-preob.jpg"/><br/>
  <?php tr('Календар на (пра-)българите', 'The calendar of (Proto-)Bulgarians', 'Der Kalender der (Proto-)Bulgaren - Y. Shopov', 'Календарь (прото-)булгары');?>
</div>
</a>

<a href="http://protobulgarians.com/Statii%20za%20prabaalgarite/Kalendar%20kitayski-new.htm" class="linkitem">
<div class="linkitem">
  <img src="links/protobulgarians.jpg"/><br/>
  <?php tr('За животинските названия в календара', 'About animal names in the calendar', 'Über Tier Namen im Kalender', 'О животинских названиях в календаре');?>
</div>
</a>

<a href="http://protobulgarians.com/alem-belem.htm" class="linkitem">
<div class="linkitem">
  <img src="links/protobulgarians-months.gif"/><br/>
  <?php tr('За названията на месеците', 'For the names of the months', 'Für die Namen der Monate', 'Для имен месяцев');?>
</div>
</a>

<a href="http://bulgaria-is-alive.com/kalendar.html" class="linkitem">
<div class="linkitem">
  <img src=""/><br/>
  <?php tr('Древна България е жива - ЖИВОТИНСКИ КАЛЕНДАР НА ПРАБЪЛГАРИТЕ', 'Ancient Bulgaria is alive - THE ANIMAL CALENDER OF BULGARIANS', 'Das alte Bulgarien lebt - TIERKALENDER DER PROTOBULGAREN', 'Древняя Болгария жива - ЖИВОТИНСКИЙ КАЛЕНДАРЬ ПРОТОБУЛГАРЫ');?>
</div>
</a>

<a href="links/pencho.mycontact.bg.html" class="linkitem">
<div class="linkitem">
  <img src=""/><br/>
  <?php tr('От Пенчо', 'From Pencho', 'Von Pentscho', 'От Пенчо');?>
</div>
</a>

<a href="links/Prabg_kalendar.pdf" class="linkitem">
<div class="linkitem">
  <img src=""/><br/>
  <?php tr('ДРЕВНОБЪЛГАРСКИЯТ КАЛЕНДАР – МИТОВЕ И РЕАЛНОСТИ. ПРОИЗХОД И ЗНАЧЕНИЯ НА НАЗВАНИЯТА', 'THE ANCIENT BULGARIAN CALENDAR - MYTS AND REALITIES. ORIGIN AND SIGNATURE OF THE NAMES', 'DER ANTIKE BULGARISCHE KALENDER - MYTHEN UND REALITÄTEN. HERKUNFT UND BEDEUTUNG DER NAMEN', 'ДРЕВНОБОЛГАРСКИЙ КАЛЕНДАРЬ - МИФЫ И РЕАЛИИ. ПРОИСХОЖДЕНИЕ И ЗНАЧЕНИЯ НАЗВАНИЙ');?>

  <!-- http://www.bulgari-istoria-2010.com/booksBG/Prabg_kalendar.pdf -->
</div>
</a>


<a href="http://ziezi.net/spiridon.html" class="linkitem">
<div class="linkitem">
  <img src=""/><br/>
  <?php tr('История во кратце о болгарском народе славенском написа Иеросхимонах Спиридон Габровски в лето 1792', 'Short history of Bulgarian Slavic Nation, written by hieromonk Spyridon Gabrovski in 1792', 'Kurtz Geschichte des Bulgarische Nation der slawischen Sprache von Priestermönch Spyridon Gabrovski im Sommer 1792 geschrieben', 'История болгарского народа славянского языка, написанная Иеросимонахом Спиридоном Габровским летом 1792 года');?>
</div>
</a>

<a href="http://calendar.samoistina.com/" class="linkitem">
<div class="linkitem">
  <img src="links/calendar.samoistina.com.gif"/><br/>
  <?php tr('Календар', 'Calendar', 'Kalender', 'Календарь');?>
</div>
</a>

<a href="http://balkan1.blog.bg/technology/2010/01/18/bylgarskiiat-kalendar.474831" class="linkitem">
<div class="linkitem">
  <img src="links/rusi-ivanov.jpg"/><br/>
  <?php tr('РАЗПРОСТРАНЯВАЙТЕ БЪЛГАРСКИЯ КАЛЕНДАР', 'SPREAD THE BULGARIAN CALENDAR', 'VERBREITEN SIE DEN BULGARISCHEN KALENDER', 'РАСПРОСТРАНЯЙТЕ БОЛГАРСКИЙ КАЛЕНДАРЬ');?>
</div>
</a>

<br/>
<br/>
<?php include('footer.php');?>
</body>
</html>
