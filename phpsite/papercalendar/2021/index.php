<?php require_once(dirname(dirname(__DIR__)).'/includes.php'); ?><!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <link rel="stylesheet" type="text/css" href="../../navigation.css" />
   <link rel="stylesheet" type="text/css" href="../../bgkalendar.css" />

   <title><?php tr('Хартиен календар за 7526/2021', 'Printed paper calendar for 7526/2021', 'Papierkalender für 7526/2021', 'Бумажный календарь для 7526/2021');?></title>
</head>
<body class="body">
<nav>
<?php  
    $DIR_PREFIX = '../../';
    include(dirname(dirname(__DIR__)).'/navigation.php');
?>
</nav>
<br/>
<div style="margin: 2em; align: auto;">
  <h3><?php tr('Хартиен календар за 7526/2021', 'Printed paper calendar for 7526/2021', 'Papierkalender für 7526/2021', 'Бумажный календарь для 7526/2021');?> </h3>
</div>

<br/><br/>
<center><b>
<?php if ($lang == 'bg') : ?>
Преглед
<?php elseif ($lang == 'en') : ?>
Preview
<?php elseif ($lang == 'de') : ?>
Предварительный просмотр
<?php elseif ($lang == 'ru') : ?>
Vorschau
<?php endif ?>
</b></center>

<center>
<!-- <a href="../../?lang=<?php tr('bg', 'en', 'de', 'ru');?>" width="50%" style="width: 60px;"><?php tr('Обратно', 'Back', 'Zurück gehen', 'Вернитесь')?></a> -->
<br/>
<a href="kalendar-2021-bg-preview.png">
<img style="max-width: 90%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" src="kalendar-2021-bg-preview.png"/>
</a>
<br/>
<!-- <a href="../../?lang=<?php tr('bg', 'en', 'de', 'ru');?>" width="50%" style="width: 60px;"><?php tr('Обратно', 'Back', 'Zurück gehen', 'Вернитесь')?></a> -->
</center>
<div style="margin: 2em; align: auto;">
  <!--
  <?php if ($lang == 'bg') : ?>
    Свали като <a href="kalendar-2021-bg.svg">SVG (Оригинал)</a>, 
    <a href="kalendar-2021-bg.png">PNG</a> или 
    <a href="kalendar-2021-bg.pdf">PDF</a>.
    <br/><br/>
  <?php elseif ($lang == 'en') : ?>
    Download as <a href="kalendar-2021-bg.svg">SVG (Original)</a>, 
    <a href="kalendar-2021-bg.png">PNG</a> or 
    <a href="kalendar-2021-bg.pdf">PDF</a>.
    <br/><br/>
  <?php elseif ($lang == 'de') : ?>
    Download als <a href="kalendar-2021-bg.svg">SVG (Original)</a>, 
    <a href="kalendar-2021-bg.png">PNG</a> oder 
    <a href="kalendar-2021-bg.pdf">PDF</a>.
    <br/><br/>
  <?php elseif ($lang == 'ru') : ?>
     Скачать как <a href="kalendar-2021-bg.svg">SVG (Оригиналь)</a>, 
    <a href="kalendar-2021-bg.png">PNG</a> или
    <a href="kalendar-2021-bg.pdf">PDF</a>.
    <br/><br/>
  <?php endif ?>
  -->
  
  <?php if ($lang == 'bg') : ?>
    Дизайнът на календара включва кръгов календар, при който като на циферблат са нанесени 365<sup>-те</sup> дни на годината, 
    като от външната страна са поставени дните по месеци на Григорианския календар, 
    а от вътрешната дните по месеците на Древния Български Календар. Така много лесно може да се види кой ден на кой съответства.
    <br/><br/>
    В кръгът е използван дизайн, който е подобен на митичната костенурка от изследванията на Слави Дончев 
    (<a href="https://www.youtube.com/watch?v=EujVzngonxM&feature=youtu.be&list=PLC1L34JwNaURJW3LnqdHzPCV6qGvL_GkO&t=425">вж. повече информация</a>), 
    като в центъра е показан магически квадрат при който сборът по редове, по колони и по диагонали винаги дава точно 15. 
    Нечетните числа са разположени на кръст в средата и символизират мъжкото начало - те оформят кръст по посоките на света, 
    а четните числа символизиращи женското начало са разположени по върховете на квадрата - по полупосокоте на света. 
    <br/><br/>
    Около него е разположен така нареченият "лунен кръговрат" (по Слави Дончев), 
    който е показан във варианта от <a href="https://tangra-bg.org/product/bblgarskiyat-naroden-kalendar-osnovi-i-sbshchnost">книгата на Георги Велев "Българският народен календар"</a> 
    (вж. също <a href="../../links/daobgkalendar.pdf">кратка статия в Списание 8</a>).
    <br/><br/>
    Около него е показан "слънчевият кръговрат" представен от 12 годишният животински цикъл. Показана е последователност при която маймуна следва овен. 
    При много изследвачи редът точно на тези две животни е разменен, поради което те са отбелязани с по една загатната въпросителна.
    <br/><br/>
    В долната част е показана таблична версия на календара за същата година, като отново имаме сравнение между Григориански (текущият съвременен календар) и Древния Български Календар. 
    Датата по Григорианския календар е показана в горния ред на всеки месец, а на долният е посочена датировката по Древния Български Календар. 
    Месеците по двата календара имат разминаване от по 10 или 11 дена и така например 1<sup>-ви</sup> Януари съответства на 11<sup>-ти</sup> ден от Първия месец (Месец Алем) от Древния Български Календар, 
    а 23<sup>-ти</sup> Януари съответства на 2<sup>-ри</sup> ден от Втория месец (Месец Тутом) от Древния Български Календар.
    <br/>
    <center><a href="saotvetstvie.png"><div style="background-image: url('saotvetstvie.png'); max-width: 600px; max-height: 377px; min-height: 377px;background-position: center top;border-radius: 2em;box-shadow: 0 0 8px 8px rgba(255,255,255, 1) inset;"> </div></a></center>
    <br/>
    <br/>
    Дните от седмицате събота и неделя по Григорианския календар са дадени на зелен фон, а същите (шести и седми ден от седмицата) при Древния Български Календар - на син фон.
    По наблюдателните от вас може би ще забележат, че те се разминават. Например 2<sup>-ри</sup> и 3<sup>-ти</sup> Януари са съответно събота и неделя, но съответните им по Древният Български Календар 
    не са 12<sup>-ти</sup> и 13<sup>-ти</sup> Алем, а 13<sup>-ти</sup> и 14<sup>-ти</sup> Алем - разминаване от един ден. Защо се получава така ? 
    <br/><br/>
    Причината е, че в Древния Български Календар имаме дни които не се броят като част от седмицата. Това са дните Ени - 31-ви Алтом (31-ви ден от Дванадесети Месец) и високосният ден Бехти - 31-ви Шехтем (31-ви ден от Шести Месец).
    След като извадим тези дни от общата продължителност на годината (365 дни при невисокосна година и 366 дни при високосна), пулучаваме 364 дни които се броят като седмични дни или това е точно 52 седмици (52 . 7 = 354). 
    <br/>
    Числото 354 получаваме и в двата случая - и при високосни години и при невисокосни, защото при невисокосна от 365 изваждаме само 1 ден - денят Ени (365 - 1 = 354), а при високосна от 366 дние изваждаме 2 дена 
    - денят Ени и високосния ден Бехти (366 - 2 = 364). 
    <br/><br/>
    Поради това, всяка година съдържа точен брой седмици - точно 52. Така всяка година винаги започва в първият ден от седмицата (условно понеделник) и винаги завършва в последния ден от седмицата (условно неделя).
    И така всяка дата от Древният Български Календар е винаги в един и същ ден от седмицата, независимо от годината. 
    <br/><br/>
    Това не е така за Григорианския календар. При него всеки един ден от годината се счита за участващ и в седмичният цикъл. Поради това, Гиргорианската година не съдържа точен брой седмици и всяка една дата може да се пада на различен ден от седмицата 
    в зависимот от конкретната година. Това е и причината заради която всяка година си купуваме нов календар за текущата година. 
    <br/>
    <br/>
    <center><a href="sedmitsa.png"><div style="background-image: url('sedmitsa.png'); max-width: 1024px; max-height: 168; min-height: 168px;background-position: center top;border-radius: 2em;box-shadow: 0 0 8px 8px rgba(255,255,255, 1) inset;"> </div></a></center>
    <br/>
    <br/><br/>
    <br/><br/>
    Месеците от Древния Български Календар са посочени и с предполагаемите им древни имена (според една от хипотезите). Например Първи Месец - Алем, Втори Месец - Тутом и т.н.
    <br/><br/>
    В средата на кръговия календар, е представена 12 годишната цикличност на Древния Български календар. Това е последователност от 12 години при която на всяка година е съпоставено животно. 
    Животните са представени с рисунка на самото животно, както и с предполагаемото му древно име. Например Плъх/Мишка - Сомор, Вол/Бик - Шегор и т.н.
    Годината 7526/2021 е година на Бика (или Вола). Древното име на тази година (Шегор) е засвидетелствано както в <a href="../../iztochnici.php?lang=bg#imennik">Именника на Българските Владетели</a>, така и в <a href="../../iztochnici.php?lang=bg#chatalarski">Чаталарския надпис</a> (под формата СИГОР).  
    
    <br/><br/>
    Според настоящия модел година 7526 по Древния Български Календар не е високосна година и затова нямаме допълнителен ден (наричан още "Ден Бехти") след края на Шестия месец (Месец Пехтем).
    Така след 30<sup>-ти</sup> ден на Шестия месец (Месец Шехтем) започва 1<sup>-ви</sup> ден от Седмия месец (Месец Сетем).
    <br/><br/>
    Новогодишният ден, който е след края на Дванадесетия месец (Месец Алтом) не се брои в рамките нито на месец, нито на седмица. С него завършва старата година и започва новата и в известен смисъл
    е едновременно част и от двете години. В нашият модел, за удобство този ден е отбелязан като последен 31<sup>-ви</sup> ден на Дванадесетия месец (Месец Алтом).
    <br/><br/>
    Фонът на календара е снимка на небесни облаци заснета над комплекс Елените, пред която е поставена замъглена палитра от преливащи бяло-зелено-червено (българският трибагреник) цветове.
    <br/><br/><br/>
    
  <?php elseif ($lang == 'en') : ?>
  <?php elseif ($lang == 'de') : ?>
  <?php elseif ($lang == 'ru') : ?>
  <?php endif ?>

  <br/>
  <br/>
  <br/>
   <script>
     function roundDecimal(value, precision) {
       var drob = value % 100; 
       var floor = Math.floor( (value - drob ) / 100);
       if (drob == null || drob == undefined || drob == 0) { 
         drob = "00";
       } else if (drob < 10) {
         drob = "0" + drob;
       }
       var str = "" + floor;
       str += "<?php tr(',', '.', '.', ',');?>"; 
       str += drob;
       return str;
     }

     function recalc() {
       var p = document.getElementById("price");
       if (p == null || p.innerHTML == null) {
         return;
       } 
       var count = document.getElementById("count");
       if (count == null || count.value == null) {
         return;
       } 
       count = count.value;
       var val = count * 752;
       if (isNaN(val) || val < 0) {
         p.innerHTML = " - ";  
       } else {
         val = roundDecimal(val);
         p.innerHTML = "" + val;
       } 
     }

     function validateForm() {
       var countMessage = document.getElementById("countmessage");
       var recipientMessage = document.getElementById("recipientmessage");
       var addressMessage = document.getElementById("addressmessage");
       var phoneMessage = document.getElementById("phonemessage");

       countMessage.innerHTML = "";
       recipientMessage.innerHTML = "";
       addressMessage.innerHTML = "";
       phoneMessage.innerHTML = "";

       var errors = false;
       var count = document.getElementById("count");
       if (count.value == null || count.value == undefined || count.value == "" || count.value.trim() == "" || isNaN(count.value) || count.value.length > 20) {
         countMessage.innerHTML = "<?php tr('Броя трябва да е цяло положително число.', 'Count must be positive integer number.', 'Dieser Wert muss eine positive ganze Zahl sein.', 'Это значение должно быть положительным целым числом.');?>";
         errors = true;
       }  
       var recipient = document.getElementById("recipient");
       if (recipient.value == null || recipient.value == undefined || recipient.value == "" || recipient.value.length > 100) {
         recipientMessage.innerHTML = "<?php tr('Получателят е задължителен', 'The name of recipient should be entered.', 'The name of recipient should be entered.', 'Имя получателя должно быть введено.');?>";
         errors = true;
       } 
       var address = document.getElementById("address");
       if (address.value == null || address.value == undefined || address.value == "" || address.value.length > 200) {
         addressMessage.innerHTML = "<br/><?php tr('Адресът за доставка е задължителен.', 'The address for delivery should not be empty.', 'Die Lieferadresse sollte nicht leer sein.', 'Адрес доставки должен не быть пустым.');?>";
         errors = true;
       } 
       var phone = document.getElementById("phone");
       if (phone.value == null || phone.value == undefined || phone.value == "" || phone.value.length > 100) {
         phoneMessage.innerHTML = "<?php tr('Телефонът за връзка е задължителен.', 'The phone contact is required.', 'Der Telefonkontakt ist erforderlich.', 'Требуется телефонный контакт.');?>";
         errors = true;
       } 
       if (errors) {
         return false;
       } 
     }

   </script>
   <form method="post" action="order.php?lang=<?php tr('bg', 'en', 'de', 'ru');?>" onsubmit="return validateForm();">
   <input type="hidden" name="lang", value="<?php tr('bg', 'en', 'de', 'ru');?>" />
   <table>
     <tr>
       <td><?php tr('Брой*', 'Count', 'Wie viele', 'Сколько');?>: </td><td><input type="text" name="count" value="1" size="10" id="count" onchange="javascript:recalc();" onkeyup="javascript:recalc();"/>
       <b><font color="red"><span id="countmessage"></span></font></b></td>
     </tr>
     <tr>
       <td><?php tr('Получател*', 'Recipient*', 'Empfänger','Получатель');?>:</td><td><input type="text" name="recipient" id="recipient" style="min-width: 22em;" placeholder="<?php tr('Иван Петров | Иванка Петрова', 'Ivan Petrov | Ivanka Petrova', 'Iwan Petrow | Iwanka Petrowa', 'Иван Петров | Иванка Петрова');?>">
       <b><font color="red"><span id="recipientmessage"><?php echo $recipientmessage;?></span></font></b></td>
     </tr>
     <tr>
       <td><?php tr('Доставка*', 'Delivery*', 'Lieferung', 'Доставка');?>: </td><td><textarea name="address" id="address" style="min-width: 22em;" placeholder="<?php tr('Адрес или офис на Спиди в България', 'Address or office of Speedy in Bulgaria', 'Adresse oder Büro von Speedy in Bulgarien.', 'Адрес или офис Спиди в Болгарии');?>" 
       rows="7" cols="35"></textarea>
       <b><font color="red"><span id="addressmessage"></span></font></b></td>
     </tr>
     <tr>
       <td><?php tr('Телефон*', 'Telephone*', 'Telefon','Телефон');?>:</td><td><input type="text" name="phone" id="phone" placeholder="000-00-00-00">
       <b><font color="red"><span id="phonemessage"></span></font></b></td>
     </tr>
     <tr>
       <td><?php tr('Заплащане', 'Price', 'Preis', 'Цена');?>: </td><td><?php tr('Наложен платеж', 'Cash on delivery', 'Nachnahme', 'Денежные средства при доставке'); ?></td>
     </tr>
     <tr>
       <td></td><td><b><span name="price" id="price"></span></b>лв</td>
     </tr>
     <tr>
       <td></td><td><?php tr('Цена за доставка не е включена', 'The price of the post delivery not included.', 'Der Preis der Postlieferung ist nicht inbegriffen.', 'Цена почтовой доставки не включена.');?></td>
     </tr>
     <tr>
       <td>&nbsp;</td><td><input type="submit" name="submit" value="<?php tr('Вземи своя хартиен календар', 'Take your paper calendar', 'Nehmen Sie Ihren Papierkalender', 'Возьмите свой бумажный календарь');?>"></td>
     </tr>
     <tr>
       <td>&nbsp;</td><td><?php tr('Или се свържете по електронна поща със', 'Alternatively, you may simply contact us on E-mal ', 'Alternativ können Sie uns einfach über E-mal kontaktieren ', 'Кроме того, вы можете просто связаться с нами на ');?><br/> <u>admin [а] bgkalendar.com</u></td>
     </tr>
     
   </table>
   </form>
   <script> recalc(); </script>

</div>
<br/>
<br/>
<br/>
<br/>
<?php include(dirname(dirname(__DIR__)).'/footer.php');?>
</body>
</html>
