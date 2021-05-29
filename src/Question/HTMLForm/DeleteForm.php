<?php

namespace Magm19\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Magm19\Question\Question;

/**
 * Form to delete an item.
 */
class DeleteForm extends FormModel
{
    private $username;

    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $username)
    {
        parent::__construct($di);
        $this->username = $username;
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Radera fråga",
            ],
            [
                "select" => [
                    "type"        => "select",
                    "label"       => "Välj fråga att ta bort:",
                    "options"     => $this->getAllItems(),
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Radera",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Get all items as array suitable for display in select option dropdown.
     *
     * @return array with key value of all items.
     */
    protected function getAllItems() : array
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $questions = ["-1" => "Välj i listan..."];
        foreach ($question->findAllWhere("user = ?", $this->username) as $obj) {
            $questions[$obj->id] = "{$obj->title} ({$obj->id})";
        }

        return $questions;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $this->form->value("select"));
        var_dump($this->form->value("select"));
        $question->delete();
        return false;
    }
}