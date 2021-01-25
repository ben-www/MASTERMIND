<?php
/**
 * Created by PhpStorm.
 * User: benjaaminnn
 * Date: 4/25/18
 * Time: 6:31 PM
 */

namespace Mastermind;


class Mastermind
{
    public function __construct()
    {
        $colors = array('O','P','G','R','Y','B');
        shuffle($colors);

        // Seed that can be used for randomizing Colors
        for ($x = 0; $x <4; $x++) {
            array_push($this->answer, $colors[$x]);
        }


    }

    /**
     * @return mixed
     */
    public function findColor($color)
    {
        if($color == 'O') {
            $res = "orange";
        }
        if($color == 'P') {
            $res = "purple";
        }
        if($color == 'G') {
            $res = "green";
        }
        if($color == 'R') {
            $res = "red";
        }
        if($color == 'Y') {
            $res = "yellow";
        }
        if($color == 'B') {
            $res = "blue";
        }
        return $res;
    }

    /**
     * @return mixed
     */
    public function createPicksTable()
    {
        $html = '<td>?:</td>';


        $picks = $this->getCurrentGuess();
        usort($picks, function($a, $b) {
            return $a['pick'] - $b['pick'];
        });

        for ($x = 1; $x <= 4; $x++) {
            $html .= '<td>';

            if(count($picks) > 0) {
                if ($picks[0]['pick'] == $x) {
                    $color = $this->findColor($picks[0]['color']);
                    $html .= '<button name="pick" value="' . $x . '"><img src="images/' . $color . '.png" alt="A empty sphere"></button>';
                    array_shift($picks);
                } else {
                    $html .= '<button name="pick" value="' . $x . '"><img src="images/empty.png" alt="A empty sphere"></button>';
                }
            }

            else {
                // No guesses all EMPTY
                $html .= '<button name="pick" value="' . $x . '"><img src="images/empty.png" alt="A empty sphere"></button>';
            }
            $html .= '</td>';
        }
        $html .= '<td>&nbsp;</td>';
        $html .= '</tr></table>';

        return $html;
    }


    /**
     * @return mixed
     */
    public function createGuessTable()
    {
        $html = null;
        $guesses = $this->getGuessArray();



        if(count($guesses) > 0) {
            for ($x = 0; $x < count($guesses); $x++) {
                $html .= '<tr>';
                $html .= '<td>' . ($x+1) . ':</td>';

                for ($k = 0; $k < count($guesses[$x]); $k++) {

                    $color = $this->findColor($guesses[$x][$k]['color']);

                    if($color == 'orange') {
                        $html .= '<td><img src="images/orange.png" alt="A orange.png sphere"></td>';
                    }
                    if($color == 'purple') {
                        $html .= '<td><img src="images/purple.png" alt="A purple.png sphere"></td>';
                    }
                    if($color == 'green') {
                        $html .= '<td><img src="images/green.png" alt="A green.png sphere"></td>';
                    }
                    if($color == 'red') {
                        $html .= '<td><img src="images/red.png" alt="A red.png sphere"></td>';
                    }
                    if($color == 'yellow') {
                        $html .= '<td><img src="images/yellow.png" alt="A yellow.png sphere"></td>';
                    }
                    if($color == 'blue') {
                        $html .= '<td><img src="images/blue.png" alt="A blue.png sphere"></td>';
                    }
                }

                $pegs = $this->getPegArray();

                $pegs = $pegs[$x];
                sort($pegs);

                // GET PEGS
                if (count($pegs) > 0) {
                    $html .= '<td>';
                    foreach($pegs as $peg) {
                        if($peg == 'R') {
                            $html .= '<img src="images/redpeg.png" alt="Red Peg"> ';
                        } else {
                            $html .= '<img src="images/whitepeg.png" alt="White Peg"> ';
                        }
                    }
                    $html .= '</td>';
                } else {
                    $html .= '<td></td>';
                }
                $html .= '</tr>';
            }
        }

        return $html;
    }



    public function updateCurrentGuess($pick, $color) {
        $temp = array('pick' => $pick, 'color' => $color);
        // check if pick exists and update if already assigned
        foreach($this->currentGuess as &$guess) {
            if($guess['pick'] == $pick) {
                $guess['color'] = $color;
                return;
            }
        }
        array_push($this->currentGuess,$temp);
    }

    public function updateGuesses(array $currentGuess) {
        array_push($this->guessArray, $currentGuess);
    }


    /**
     * @return array
     */
    public function getGuessArray()
    {
        return $this->guessArray;
    }




    /**
     * @return array
     */
    public function getCurrentGuess()
    {
        $picks = $this->currentGuess;
        usort($picks, function($a, $b) {
            return $a['pick'] - $b['pick'];
        });
        $this->currentGuess = $picks;

        return $this->currentGuess;
    }

    /**
     * @return array
     */
    public function getPicks()
    {
        $temp = array();
        foreach($this->getCurrentGuess() as $guess) {
            array_push($temp, $guess['color']);
        }
        $this->picks = $temp;

        return $this->picks;
    }

    /**
     * @param bool $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    /**
     * @return bool
     */
    public function isWinner()
    {
        return $this->winner;
    }



    /**
     * @param array $currentGuess
     */
    public function setCurrentGuess($currentGuess)
    {
        $this->currentGuess = $currentGuess;
    }



    /**
     * @param mixed $numPlayers
     */
    public function setPlayer($name)
    {
        $this->playerName = $name;
    }

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->playerName;
    }


    /**
     * @param mixed $numPlayers
     */
    public function setGuessNum($num)
    {
        $this->guessNum = $num;
    }

    /**
     * @param mixed $numPlayers
     */
    public function getGuessNum()
    {
        return $this->guessNum;
    }

    /**
     * @return array
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @return array
     */
    public function getPegArray()
    {
        return $this->pegArray;
    }

    /**
     * @param array $pegArray
     */

    public function addPegArray($pegArray)
    {
        array_push($this->pegArray, $pegArray);
    }

    public function setPegArray($pegArray)
    {
        $this->pegArray = $pegArray;
    }

    /**
     * @return bool
     */
    public function isGiveUp()
    {
        return $this->giveUp;
    }

    /**
     * @param bool $giveUp
     */
    public function setGiveUp($giveUp)
    {
        $this->giveUp = $giveUp;
    }



    private $playerName;              // Player Name
    private $guessNum = 0;            // How many guesses we have made
    private $winner = false;
    private $giveUp = false;
    private $pegArray = array();
    private $currentGuess = array();
    private $guessArray = array();    // Array of guesses to build our table
    private $answer = array();
    private $picks = array();

}