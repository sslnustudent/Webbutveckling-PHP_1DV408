<?php

require_once("src/LoginController.php");
require_once("viewHTML.php");

session_start();


$controller = new LoginController();
$htmlBody = $controller->doCheckLogin();

$view = new viewHTML();
$view->showHTML($htmlBody);
