<?php

namespace Magm19\Comment\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Magm19\Comment\Comment;

/**
 * Form to create an item.
 */
class CreateAnswerCommentForm extends FormModel
{

    private $id;

    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->id = $id;
        $this->form->create(
            [
                "id" => __CLASS__,
                "class" => "comment-wrap",
            ],
            [
                "parentId" => [
                    "type" => "hidden",
                    "value" => $id
                ],
                "body" => [
                    "type" => "textarea",
                    "label" => "",
                    "placeholder" => "Kommentera...",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Kommentera",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->body = $this->form->value("body");
        $comment->user = $this->di->session->get("user");
        $comment->parentId = $this->form->value("parentId");
        $comment->parentIsAnswer = 1;
        $comment->created = date("Y-m-d H:i:s");
        $comment->save();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("comment")->send();
    // }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
