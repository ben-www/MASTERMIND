<?php
/**
 * Created by PhpStorm.
 * User: benjaaminnn
 * Date: 4/25/18
 * Time: 6:29 PM
 */

require __DIR__ . '/../lib/game.inc.php';

$controller = new \Mastermind\newGameController($mastermind, $_POST, $_SESSION);
//var_dump($_SESSION);
header("location: " . $controller->getRedirect());
exit;