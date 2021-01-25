<?php
/**
 * Created by PhpStorm.
 * User: benjaaminnn
 * Date: 4/25/18
 * Time: 6:46 PM
 */

namespace Mastermind;


class View
{
    const SESSION_ERROR = "game_error";

    /**
     * View constructor.
     * @param Site $site. The Site object
     */
    public function __construct(Mastermind $mastermind, array $get, array $session) {
        $this->mastermind = $mastermind;
        $this->session = $session;
        $this->get = $get;
    }

    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get the redirect location link.
     * @return page to redirect to.
     */
    public function getRedirect() {
        return $this->redirect;
    }


    public function present()
    {
        $html = <<<HTML
        <form id="signin" method="post" action="post/index-post.php">
  <fieldset>
    <p><img src="images/banner.png" width="521" height="346" alt="Mastermind Banner"></p>
    <p>Welcome to Mastermind</p>
    <p><label for="name">Your Name: </label>
      <input type="text" name="name" id="name"></p>
HTML;
        $html .= $this->errorMsg();
        $html .= <<<HTML
        <p><input type="submit" name="submit" value="Start Game"></p>
        </fieldset>
    </form>
HTML;
        return $html;
    }
/**
* Get any optional error messages
* @return string Optional error message HTML or empty if none.
*/
    public function errorMsg() {
        if(isset($this->get['e']) and isset($this->session[self::SESSION_ERROR])) {
            return '<p class="msg">' . $this->session[self::SESSION_ERROR] . '</p>';
        } else {
            return '';
        }
    }

    protected $mastermind;
    private $title = "";	///< The page title

    protected $redirect = null;	///< Optional redirect?
    protected $session;		///< $_SESSION
    protected $get;


}