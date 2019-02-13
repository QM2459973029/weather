<?php
$data=file_get_contents("city.txt");
$arr=array();
$arr=explode('|',$data);
var_dump("<pre>");
var_dump($arr);
?>