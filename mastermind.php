<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Mastermind\MastermindView($mastermind, $_GET, $_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="mastermind.css" type="text/css" rel="stylesheet"/>
  <title>Mastermind</title>
</head>


<body>
<?php
echo $view->present();
?>
</body>
</html>