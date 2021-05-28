<?php

namespace Magm19\Answer;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Magm19\Answer\HTMLForm\CreateForm;
use Magm19\Question\Question;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class AnswerController implements ContainerInjectableInterface
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
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        $page->add("answer/create", [
            "items" => $answer->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di, $id);
        $form->check();
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);
        $user = $this->di->session->get("user");
        $isLoggedIn = isset($user);

        $page->add("answer/create", [
            "form" => $form->getHTML(),
            "question" => $question,
            "isLoggedIn" => $isLoggedIn,
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }
}
