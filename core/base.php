<?php 

function conn(){
    return mysqli_connect("localhost","root","","sp_blog");
}

$info = array(
    "name" => "Sample Blog",
    "short" => "SB",
    "description" => "ကျောင်းသားများအတွက် sample project"
);

$role = ["Admin","Editor","User"];


$url = "http://{$_SERVER['HTTP_HOST'] }/WDP/Simple_blog/";

date_default_timezone_set('Asia/Yangon');