<?php
/**
 * Created by PhpStorm.
 * User: benjaaminnn
 * Date: 4/25/18
 * Time: 6:29 PM
 */

require __DIR__ . '/../lib/game.inc.php';

$controller = new \Mastermind\MastermindController($mastermind, $_POST, $_SESSION);

if($controller->isReset() and $controller->isExit()) {
    unset($_SESSION[GAME_SESSION]);
}

if($controller->isReset()) {
    $playerName = $mastermind->getPlayer();
    $newMM = new Mastermind\Mastermind();
    $newMM->setPlayer($playerName);

    unset($_SESSION[GAME_SESSION]);
    $_SESSION[GAME_SESSION] = $newMM;


}
header("location: " . $controller->getRedirect());
exit;