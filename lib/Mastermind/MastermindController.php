<?php
/**
 * Created by PhpStorm.
 * User: benjaaminnn
 * Date: 4/25/18
 * Time: 6:59 PM
 */

namespace Mastermind;


class MastermindController
{
    public function __construct(Mastermind $mastermind, array $post, array &$session)
    {
        $this->mastermind = $mastermind;
        // We must assign by reference if we want to be
        // able to change the session.
        $this->session = &$session;

        // Ensure no error is set in the session
        unset($this->session[MastermindView::SESSION_ERROR]);

        if (isset($post['exit'])) {
            $this->reset = true;
            $this->exit = true;
            $this->redirect = "../";
            return;
        }
        if (isset($post['newgame'])) {
            $this->reset = true;
            $this->redirect = "../mastermind.php";
            return;
        }

        if (isset($post['pick']) and !isset($post['color'])) {
            // ERROR
            $this->error("../mastermind.php", "Please select a color!");
            return;
        }

        if (isset($post['pick']) and isset($post['color'])) {
            $pick =  strip_tags($post['pick']);
            $color =  strip_tags($post['color']);
            $mastermind->updateCurrentGuess($pick,$color);

            $this->redirect = "../mastermind.php";
        }



        // We have our guess
        if (isset($post['guess'])) {
            if(count($this->mastermind->getCurrentGuess()) != 4) {
                // ERROR
                $this->error("../mastermind.php", "Must select a color for all spheres!");
                return;

            }
            $this->mastermind->setGuessNum($this->mastermind->getGuessNum() + 1);
            $this->mastermind->UpdateGuesses($this->mastermind->getCurrentGuess());


            $picks = $this->mastermind->getPicks();
            $ans = $this->mastermind->getAnswer();

            $temp = array();
            for ($x = 0; $x <4; $x++) {
                if($picks[$x] == $ans[$x]) {
                    array_push($temp, 'R');
                } else {
                    if (in_array($picks[$x], $ans)) {
                        array_push($temp, 'W');
                    }
                }
            }
            $this->mastermind->addPegArray($temp);

            // You win
            if($picks === $ans) {
                $this->mastermind->setWinner(true);
            }

            $this->mastermind->setCurrentGuess(array());
            $this->redirect = "../mastermind.php";
            return;
        }

        if (isset($post['giveup'])) {
            $temp = $this->mastermind->getAnswer();
            for ($x = 1; $x <=4; $x++) {
                $this->mastermind->updateCurrentGuess($x,$temp[$x-1]);
            }

            $temp = array();
            for ($x = 0; $x <4; $x++) {
                array_push($temp, 'R');
            }
            $this->mastermind->setGuessNum($this->mastermind->getGuessNum() + 1);
            $this->mastermind->addPegArray($temp);
            $this->mastermind->UpdateGuesses($this->mastermind->getCurrentGuess());
            $this->mastermind->setGiveup(true);

            $this->redirect = "../mastermind.php";
        }
    }



    public function isReset(){
        if($this->reset==false){
            return false;
        }
        return true;
    }


    public function isExit(){
        if($this->exit==false){
            return false;
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * General mechanism for error handling
     * @param $page Page we go to
     * @param $msg Message to display on the page
     */
    protected function error($page, $msg) {
        $this->redirect = "$page?e";
        $this->session[MastermindView::SESSION_ERROR] = $msg;
    }


    private $redirect;	///< Page we will redirect the user to.

    private $reset = false;
    private $exit = false;
    private $mastermind;
    private $session;		///< $_SESSION
}