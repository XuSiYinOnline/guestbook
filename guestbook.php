<?php
$file = "guestbook.txt";
$data = date('d.m.Y H:i'. ' 北京时间');
$text = $_REQUEST['text'];
$name = $_REQUEST['name'];
if (@$_REQUEST['add']) {
  $f = fopen($file, "a");
  if (@$_REQUEST['text'] && @$_REQUEST['name']) fputs($f, '<span class="date-mess">'.'<span class="name">'.$name. "</span> &nbsp;&nbsp;&nbsp;".$data. " </span><br>". " <span class='message'>" .$text ."</span>"."\n");
  fclose($f);
  $random = time();    //随机参数,避免缓存.
  Header("Location: http://{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}?$random#form");
  exit();
}
$gb = @file($file);
if (!$gb) $gb = [];
