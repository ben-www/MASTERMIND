<?php
/**
 * Created by PhpStorm.
 * User: benjaaminnn
 * Date: 4/25/18
 * Time: 7:03 PM
 */

namespace Mastermind;


class newGameController
{
    public function __construct(Mastermind $mastermind, array $post, array &$session)
    {
        $this->mastermind = $mastermind;

        // We must assign by reference if we want to be
        // able to change the session.
        $this->session = &$session;

        // Ensure no error is set in the session
        unset($this->session[View::SESSION_ERROR]);

        if (isset($post['submit'])) {
            if(strlen($post['name']) !=0) {
                $this->mastermind->setPlayer($post['name']);
                $this->redirect = "../mastermind.php";
            } else {
                // ERROR
                $this->error("../index.php", "Please enter a name!");
                return;
            }
        }
    }

    /**
     * General mechanism for error handling
     * @param $page Page we go to
     * @param $msg Message to display on the page
     */
    protected function error($page, $msg) {
        $this->redirect = "$page?e";
        $this->session[View::SESSION_ERROR] = $msg;
    }


    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    private $redirect;	///< Page we will redirect the user to.
    private $mastermind;    // The game
    private $session;		///< $_SESSION

}