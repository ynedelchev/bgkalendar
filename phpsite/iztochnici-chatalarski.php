
<?php require_once('includes.php'); ?><!DOCTYPE html>

<style>
 .verticalseparator {
    box-shadow: -5px 4px 0px -4px blue;
 }
 .chatalarski {
   content: "";
   position: absolute;
   top: -5px;
   left: -4px; 
   border: 3px solid rgba(255, 0, 0, 0.5);
   width: 85px;
   height: 12.5em;
 }
</style>

<h3><a name="chatalarski"></a><?php tr('Чаталарски надпис', 'Chatalar Inscription', 'Tschatalarinschrift', 'Чаталарский надпись');?></h3>
<?php if ($lang == 'bg') : ?>
  Чаталарският надпис е издълбан върху каменна колона надпис направен по поръка на българския владетел Омуртаг. 
  Намерен е през 1905 година близо до село Чаталар (днешното <a href="https://osm.org/go/x1sXryc--?m=">село Хан Крум</a>, близо до град Шумен) 
  от археолога Рафаил Попов по време на археологически разкопки. 
  <br/>
  Колоната и надписът върху нея са интересни от гледна точка на Древния  Български Календар с това, че съдържат двойно датиране на събитие 
  по Древния Български Календар (СИГОР ЕЛЕМ или ШИГОР ЕЛЕМ)  и по летоброенето на Източната Римска Империя (15<sup>-ти</sup> Индикт). 
  <br/>
  Оригиналното изписване е с така наречените "гръцки букви": <b>CΙΓΟΡ ΕΛΕΜ</b> (<img src="images/sigorelem.png" alt="СИГОР ЕЛЕМ"/>; <b>СИГОР ЕЛЕМ</b>), като поради липса на буква за звука "<b>Ш</b>", се предполага, 
  че оригиналното звучене е било <b>ШИГОР</b> или дори <b>ШЕГОР</b> при евентуално потъмняване на първата неударена сричка. 
  Това вече кореспондира с предполагаемото име на година <span class="oldbgr">шегор</span> от Именника на българските владетели.
  Думата <b>ΕΛΕΜ</b> (<b>ЕЛЕМ</b>) има пълно припокриване с предполагаемото име на месец <span class="oldbgr">елем</span> от Именника на българските владетели.  
  <br/>
  <br/>
  Петнайсти индикт по летоброенето на Източната Римска Империя се припокрива с края на 821<sup>-ва</sup> и началото на 822<sup>-ра</sup> година по Грегорианския календар.
  Това ни позволява доста точно да датираме древнобългарската година на бика/вола (<b>шегор</b>). 
  Според Александра Делова (виж секция <a href="links/Astronomiya-na-PraBalgarite-Aleksandra-Delova.pdf">Връзка с други календарни системи</a>),
  тя съответства на 821<sup>-ва</sup> горина от Грегорианския календар.
<?php elseif ($lang == 'en') : ?>
The translation of this paragraph is not ready yet. If you want to contribute to that translation, please contact admin [a] bgkalendar.com. Link to the <a href="iztochnici.php?lang=bg#chatalarski">bulgarian version</a>.
<?php elseif ($lang == 'de') : ?>
Die Übersetzung ist noch nicht fertig. Um diesen Absatz zu übersetzen, wenden Sie sich bitte an admin [a] bgkalendar.com.  Link zu einer Seite <a href="iztochnici.php?lang=en#chatalarski">in Englisch</a>.
<?php elseif ($lang == 'ru') : ?>
Перевод еще не готов. Чтобы помочь перевести этот пункт, пожалуйста, свяжитесь с admin [ a ]  bgkalendar.com.  Ссылка на страницу на <a href="iztochnici.php?lang=bg#chatalarski">болгарском языке.</a>
<?php endif ?>
  <br/>
  <br/>
  <br/>
  <div style="border: 1px solid black; position: absolute; width: auto; margin-left: 1em; padding-bottom: 1em; padding-right: 1em;">
  <table style="border-spacing: 0; border-collapse: collapse; text-align: center;">
   <tr style="text-align: center;">
      <th style="text-align: right; vertical-align: bottom;">Летоброене по:</th>
      <td colspan="31">&nbsp;</td>
      <td colspan="5" style="text-align: left; position: relative; color: rgba(255, 0, 0, 0.8); padding-bottom: 5px;"><div class="chatalarski">&nbsp;</div>чаталарски<br/>надпис</td>
      <td colspan="31">&nbsp;</td>
   </tr>
   <tr style="text-align: center;">
      <th style="text-align: right;">Източна Римска Империя: </th>
      <td colspan="19" style="border-bottom: 1px solid blue;">&nbsp;</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">14<sup>-ти</sup> Индикт</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">15<sup>-ти</sup> Индикт</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">1<sup>-ви</sup> Индикт</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">&nbsp;</td>
   </tr>
   <tr style="text-align: center;">
      <th style="text-align: right;">Грегориански Календар: </th>
      <td colspan="12" style="border-bottom: 1px solid blue;">&nbsp;</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">820<sup>-та</sup> година</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">821<sup>-ва</sup> година</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">822<sup>-ра</sup> година</td>
      <td colspan="19" class="verticalseparator" style="border-bottom: 1px solid blue;">&nbsp;</td>
   </tr>
   <tr style="text-align: center;">
      <th style="text-align: right;">Древният Български Календар: </th>
      <td colspan="13" style="border-bottom: 1px solid blue;">&nbsp;</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">&nbsp;</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">&nbsp; <b>ШЕГОР</b></td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">&nbsp;</td>
      <td colspan="18" class="verticalseparator" style="border-bottom: 1px solid blue;">&nbsp;</td>
   </tr>
   <tr style="text-align: center;">
      <th style="text-align: right;">Китайският Календар: </th>
      <td colspan="13" style="border-bottom: 1px solid blue;">&nbsp;</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">ПЛЪХ</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">ВОЛ</td>
      <td colspan="12" class="verticalseparator" style="border-bottom: 1px solid blue;">ТИГЪР</td>
      <td colspan="18" class="verticalseparator" style="border-bottom: 1px solid blue;">&nbsp;</td>
   </tr>
   <tr>
      <td></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>

      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>

      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>

      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>

      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
      <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td> <td style="min-width: 5px;"></td>
  </table>
  </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  
  <br/>
<?php if ($lang == 'bg') : ?>
  Днес колоната се съхранява в <a href="https://osm.org/go/x1DHaROM0--?m=">Националния Археологически Музей в София</a>, 
  а нейно копие можете да откриете също и в <a href="https://osm.org/go/x1tlnoGYQ?m=">археологическия музей на град Плиска</a>
<?php elseif ($lang == 'en') : ?>
  Today the column is kept in <a href="https://osm.org/go/x1DHaROM0--?m=">National Archeological Museum in Sofia</a>, 
  and a copy of it can be found als in the <a href="https://osm.org/go/x1tlnoGYQ?m=">archeological museum in the town of Pliska</a>
<?php elseif ($lang == 'de') : ?>
<?php elseif ($lang == 'ru') : ?>
<?php endif ?>
<br/><br/>
<table>
   <tr>
      <td class="blueborder" style="font-weight: bold;">
          <?php tr('Оригинален текст', 'The Original Text', 'Der Originaltext', 'Оригинальный текст'); ?>
      </td>
      <td class="blueborder" style="font-weight: bold;">
          <?php tr('Превод', 'Translation', 'Übersetzung', 'Перевод'); ?>
      </td>
   </tr>
   <tr>
      <td class="blueborder" style="text-align: left; width: 555px;" >
        ΚΑΝΑCYΒΙΓΙ ΩΜΟΡΤΑΓ ΙC ΤΙΝ ΓΙΝ ΟΠΟΥ ΕΓΕΝΙΘΙΝ<br/>
        ΕΚ ΘΕΟΥ ΑΡΧΟΝ ΕCΤΙ ΙC ΤΙC ΠΛCΚΣΑC ΤΟΝ ΚΑΝΠΟΝ<br/>
        ΜΕΝΟΝΤΑ ΕΠΥΗCΕ ΑΥΛΙΝ ΙC ΤΙΝ ΤΟΥΝΤΖΑΝ ΚΕ<br/>
        ΜΕΤΙΓΑΓΕΝ ΤΙΝ ΔΥΝΑΜΙΝ ΤΟΥ ΙC ΤΟΥΣ ΓΡΙΚΟΥC<br/>
        ΚΕ CΚΛΑΒΟΥC ΚΕ ΤΕΧΝΕΟC ΕΠΥΗΣΕ ΓΕΦΥΡΑΝ ΙΣ ΤΙΝ ΤΟΥΝΤΖΑΝ<br/>
        ΜΕ ΤΟ ΑΥΛΙΝ ΣΤΥΛΟΥΣ ΤΕΣΣΑΡΙC ΚΕ ΕΠΑΝΟ ΤΟΝ CΤΥΛΟΝ<br/>
        ΕCΤΙCΕ ΛΕΟΝΤΑC ΔΥΟ Ο θΕΟC ΑΞΙΟCΙ ΤΟΝ ΕΚ ΘΕΟΥ ΑΡΧΟΝΤΑ<br/>
        ΜΕ ΤΟΝ ΠΟΔΑ ΑΟΥΤΟΥ ΤΟΝ ΒΑΣΙΛΕΑ ΚΑΛΟΠΑΤΟΥΝΤΑ<br/>
        ΕΟC ΤΡΕΧΙ Η ΤΟΥΝΤΖΑ [---- ΚΕ ΕΟΣ ΤΟΥC ΠΟΛΛΟΥC ΒΟΥΛΓΑΡΙC<br/>
        ΕΠΕΧΟΥΝΤΑ ΤΟΥC ΕΧΘΡΟΥC ΑΥΤΟΥ ΥΠΟΤΑCΟΝΤΑ<br/>
        ΧΕΡΟΝΤΑ ΚΑΙ ΑΓΑΛΙΟΜΕΝΟC ΖΙCΙΝ ΕΤΙ ΕΚΑΤΟΝ<br/>
        ΙΤΟ ΔΕ ΚΕ Ο ΚΕΡΟC ΟΤΑΝ ΕΚΤΙΣΤΑΝ<br/>
        ΒΟΥΛΓΑΡΙCΤΙ CΙΓΟΡ ΕΛΕΜ ΚΕ ΓΡΙΚΙCΤΙ<br/>
        ΙΝΔΙΚΤΙΟΝΟC ΙΕ <br/>
      </td>
      <td class="blueborder" style="text-align: left; width: 555px;" >
        <?php if ($lang == 'bg') : ?>
          Канасювиги Омортаг е кан от бога в земята, дето се е родил. 
          Като остая [да пребъдва] в лагера на Плиска, 
          той построи аул на Туча 
          и уголеми силата си спрямо гърци и склавяни. 
          И построи изкусно мост на Туча отзад аула [укрепление]; 
          а в самата крепост постави четири стълба и между стълбовете 
          два медни лъва. Нека бог удостои хана от бога да притиска 
          с ногата си императора, докато тече Туча и докато тя задържа 
          многото български противници, и като покорява враговете си, 
          в радост и веселие да проживее сто години. А времето, когато 
          той [аулът] биде построен, 
          беше по (пра)български сигор елем, 
          а по гръцки 15-и индиктион. 
        <?php elseif ($lang == 'en') : ?>
          Kanasubigi Omortag, in the land where he was born
          is lord (archon) by God. In the field of Pliska
          staying he made a court/camp (aulis) at [the river] Ticha (Kamchiya)
          and moved his forces against the Greeks (i.e. Byzantines)
          and the Sklavs and skillfully erected a bridge at Ticha
          together with the camp [he put] four columns and above the columns
          he erected two lions. May God grant the Lord by God
          to crush with his foot the Byzantine Emperor (Basileus)
          until Ticha flows... and over the many Bulgarians
          to rule, to subjugate his enemies,
          to live in joy and happiness for a hundred years
          The time when this was built was
          in Bulgarian Shigor Elem and in Greek
          Indiction 15. 
        <?php elseif ($lang == 'de') : ?>
        <?php elseif ($lang == 'ru') : ?>
        <?php endif ?>
      </td>
   </tr>
   <tr>
      <td class="blueborder" style="font-weight: bold;">
          <?php tr('Отпечатък от оригиналния текст', 'Imprint of the original text', 'Impressum des Originaltextes', 'Отпечаток оригинального текста'); ?>
      </td>
      <td class="blueborder" style="font-weight: bold;">
          <?php tr('Колоната', 'The Column', 'Die Spalte', 'Колонна'); ?>
      </td>
   </tr>
   <tr>
      <td class="blueborder" style="text-align: left; width: 555px;" >
        <img src="images/chatalar-inscript.jpg" alt="<?php tr('Отпечатък', 'Imprint', 'Impressum', 'Отпечаток');?>"/>
      </td>
      <td class="blueborder" style="text-align: left; width: 555px;" >
        <a href="images/chatalar-column-copy-full.jpg" name="chatalarcolumn">
          <img src="images/chatalar-column-copy.jpg" alt="<?php tr('Колоната', 'The Column', 'Spalte', 'Колонна');?>"/>
        </a>
        <br/>
        <?php if ($lang == 'bg') : ?>
          Копие на колоната на чаталарския надпис, поставено в <a href="https://osm.org/go/x1tlnoGYQ?m=">археологическият музей в град Плиска</a>.
        <?php elseif ($lang == 'en') : ?>
          A copy of the column of the Chatalar Transkript, that is kept in the <a href="https://osm.org/go/x1tlnoGYQ?m=">archeological museum in the town of Pliska</a>.
        <?php elseif ($lang == 'de') : ?>
        <?php elseif ($lang == 'ru') : ?>
        <?php endif ?>
      </td>
   </tr>
</table>
