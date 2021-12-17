<?php

//Postavljanje obavještenja unutar stranice ukoliko je coockie setovan
//odmah po postavljanju briše coockie

if(isset($_COOKIE['notification']))
{
?>
<div class="<?=$_SESSION['alert']?>">
  <?= $_COOKIE['notification'] ?>
</div>
<?php
    setcookie("notification", "", time()-3600, "/");
}
?>