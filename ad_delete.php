<?php

require_once "core/auth.php";
require_once "core/base.php";
require_once "core/functions.php";

$id = $_GET['id'];
if(adDelete($id)){
    linkTo("ad_list.php");
}

?>