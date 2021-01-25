<?php
/**
 * Created by PhpStorm.
 * User: benjaaminnn
 * Date: 4/25/18
 * Time: 7:36 PM
 */

namespace Mastermind;


class MastermindView Extends View
{
    const SESSION_ERROR = "game_error";

    public function __construct(Mastermind $mastermind, array $get, array $session) {
        parent::__construct($mastermind, $get, $session);

    }

    public function present() {
        $player = $this->mastermind->getPlayer();
        $guessNum = $this->mastermind->getGuessNum();

        $html = <<<HTML
        <form id="gameform" action="post/game-post.php" method="POST">
  <fieldset>
    <p>$player's Mastermind</p>
    <table class="game">
HTML;

        // for each guess Build Table
        if($this->mastermind->getGuessNum() > 0) {
            $html .= $this->mastermind->createGuessTable();
        }

        if($this->mastermind->isWinner() == false and $this->mastermind->isGiveUp() == false) {
            $html .= $this->mastermind->createPicksTable();
            $html .= '    <table class="picker">
      <tr>
        <td><img src="images/orange.png" alt="A orange.png sphere"><br><input type="radio" name="color" value="O"></td>
        <td><img src="images/purple.png" alt="A purple.png sphere"><br><input type="radio" name="color" value="P"></td>
        <td><img src="images/green.png" alt="A green.png sphere"><br><input type="radio" name="color" value="G"></td>
        <td><img src="images/red.png" alt="A red.png sphere"><br><input type="radio" name="color" value="R"></td>
        <td><img src="images/yellow.png" alt="A yellow.png sphere"><br><input type="radio" name="color" value="Y"></td>
        <td><img src="images/blue.png" alt="A blue.png sphere"><br><input type="radio" name="color" value="B"></td>
      </tr>
    </table>';
        } else {
            $html .= '</tr></table>';
        }


        if($this->mastermind->isWinner()) {
            $html .= '   <p class="end">You guess correctly!</p> <input type="submit" class="winner" name="newgame" value="New Game"></p>
<p><input type="submit" name="exit" value="Exit"></p>';
        } elseif ($this->mastermind->isGiveUp()) {
            $html .= '   <p class="end">You gave up!</p> <input type="submit" class="winner" name="newgame" value="New Game"></p>
<p><input type="submit" name="exit" value="Exit"></p>';
        }
        else {
            $html .= $this->errorMsg();
            $html .= '    <p><input type="submit" name="guess" value="Guess">
      <input type="submit" name="giveup" value="Give Up">
      <input type="submit" name="newgame" value="New Game"></p>
    <p><input type="submit" name="exit" value="Exit"></p>';

        }
        $html .= <<<HTML
  </fieldset>
</form>
<p class="solution">
HTML;

        // SOLUTION
        foreach($this->mastermind->getAnswer() as $color) {
            if($color == 'O') {
                $html .= '<img src="images/orange.png" alt="A orange.png sphere"> ';
            }
            if($color == 'P') {
                $html .= '<img src="images/purple.png" alt="A purple.png sphere"> ';
            }
            if($color == 'G') {
                $html .= '<img src="images/green.png" alt="A green.png sphere"> ';
            }
            if($color == 'R') {
                $html .= '<img src="images/red.png" alt="A red.png sphere"> ';
            }
            if($color == 'Y') {
                $html .= '<img src="images/yellow.png" alt="A yellow.png sphere"> ';
            }
            if($color == 'B') {
                $html .= '<img src="images/blue.png" alt="A blue.png sphere"> ';
            }
        }
        return $html;
    }



}