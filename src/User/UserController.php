<?php

namespace Magm19\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Magm19\User\HTMLForm\UserLoginForm;
use Magm19\User\HTMLForm\CreateUserForm;
use Magm19\User\HTMLForm\UpdateUserForm;
use Magm19\Question\Question;
use Magm19\Answer\Answer;
use Magm19\Comment\Comment;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet(): object
    {
        $page = $this->di->get("page");
        $user = $this->di->session->get("user");
        $isLoggedIn = isset($user);

        if ($this->di->session->get("user")) {
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $userData = $user->getDataFromUsername($this->di->session->get("user"));
        }

        if ($isLoggedIn) {
            $page->add("User/Profile", [
                "content" => "Profil",
                "userData" => $userData ?? "",
                "isLoggedIn" => $isLoggedIn,
            ]);
        } else {
            return $this->loginAction();
        }

        return $page->render([
            "title" => "Din Profil"
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction(): object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("User/Login", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Logga in",
        ]);
    }



    /**
     * Logs out user and renders login form
     *
     */
    public function logoutAction(): object
    {
        $this->di->session->delete("user");
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("User/Login", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Logga in",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction(): object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Skapa användare",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function updateAction($id): object
    {
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();
        $user = $this->di->session->get("user");

        if (isset($user)) {
            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);
        } else {
            return $this->loginAction();
        }

        return $page->render([
            "title" => "Uppdatera användare",
        ]);
    }



    public function viewAction($userId): object
    {
        $page = $this->di->get("page");
        $user = new User();
        $question = new Question();
        $answer = new Answer();
        $comment = new Comment();

        $user->setDb($this->di->get("dbqb"));
        $question->setDb($this->di->get("dbqb"));
        $answer->setDb($this->di->get("dbqb"));
        $comment->setDb($this->di->get("dbqb"));

        if (is_numeric($userId)) {
            $user = $user->find("id", $userId);
        } else {
            $user = $user->findWhere("username = ?", $userId);
        }

        $questions = $question->findAllWhere("user = ?", $user->username);
        $answers = $answer->findAllWhere("user = ?", $user->username);
        $comments = $comment->findAllWhere("user = ?", $user->username);

        $page->add("User/view", [
            "username" => $user->username,
            "created" => $user->created,
            "questions" => $questions,
            "answers" => $answers,
            "comments" => $comments,
        ]);


        return $page->render([
            "title" => "A create user page",
        ]);
    }




    public function getGravatarLink($username, $di, $size = 80): string
    {
        $user = new User();
        $user->setDb($di->get("dbqb"));
        $userObj = $user->find("username", $username);
        $link = $this->getGravatar($userObj->email, $size);

        return $link;
    }



    /**
     * @return string of gravatar image
     */
    private function getGravatar($email, $size = 80, $default = 'mp', $rating = 'g')
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$size&d=$default&r=$rating";
        return $url;
    }
}
