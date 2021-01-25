<?php
require 'lib/game.inc.php';
$view = new Mastermind\View($mastermind, $_GET, $_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mastermind Signin</title>
  <link href="mastermind.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
echo $view->present();
?>
</body>
</html>
