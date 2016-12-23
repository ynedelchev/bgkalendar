<?php
$redirectPage = '2017-7522.html';
header("Location: ".$redirectPage, true, 303);
?>
<html>
  <head>
     <title>Redirection Page</title>
     <script lang="javascript">
        function redirectFunction() {
           window.location.replace(window.location + '/<?php echo $redirectPage;?>');
        }
     </script>
  </head>
  <body onload="javascript:redirectFunction();">
    If you do not get automatically redirected, please click 
    <a href="<?php echo $redirectPage;?>">here</a>.
  </body>
</html>
