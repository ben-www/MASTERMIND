<?php
require __DIR__ . "/../vendor/autoload.php";
require 'Mastermind/Mastermind.php';
require 'Mastermind/MastermindController.php';
require 'Mastermind/View.php';
require 'Mastermind/newGameController.php';

// Start the PHP session system
session_start();

define("GAME_SESSION", 'mastermind');

// If there is a Game session, use that. Otherwise, create one
if(!isset($_SESSION[GAME_SESSION])) {
    $_SESSION[GAME_SESSION] = new Mastermind\Mastermind();
}

$mastermind = $_SESSION[GAME_SESSION];