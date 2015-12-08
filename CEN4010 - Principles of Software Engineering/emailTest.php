<?php
// the message
$msg = "Blue mix has a email function";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("andrewsleao@gmail.com","BlueMix Test",$msg);
?>