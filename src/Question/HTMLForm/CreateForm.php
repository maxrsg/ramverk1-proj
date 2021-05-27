<?php

namespace Magm19\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Magm19\Question\Question;
use Magm19\Tag\Tag;
use Magm19\Tag\QuestionTag;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{

    private $questionId;



    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Skapa fråga",
            ],
            [
                "title" => [
                    "type" => "text",
                    "label" => "Titel",
                    "validation" => ["not_empty"],
                ],

                "body" => [
                    "type" => "textarea",
                    "label" => "Text",
                    "validation" => ["not_empty"],
                ],

                "tags" => [
                    "type"        => "select-multiple",
                    "label"       => "Välj mellan befintliga taggar:",
                    "options"     => $this->getAllTags(),
                ],

                "newTags" => [
                    "type" => "text",
                    "label" => "Skapa nya taggar",
                    "description" => 'Skriv in taggar separerade med "," <br> exempel: Rolex, Hjälp',
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skapa fråga",
                    "callback" => [$this, "callbackSubmit"],
                ],
            ]
        );
    }



    /**
     * Get all tags from database,
     *
     * @return array with key value of all items.
     */
    protected function getAllTags() : array
    {
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));

        $tags = [];
        foreach ($tag->findAll() as $obj) {
            $tags[$obj->id] = "{$obj->body}";
        }

        return $tags;
    }



    /**
     * create a new tag
     * @param value string name of the new tag
     */
    protected function createTag($value, $questionId)
    {
        $allTags = $this->getAllTags();
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        if (!in_array($value, $allTags)) {
            $tag->body = $value;
            $tag->save();
        } else {
            $tag->find("body = ?", $value);
        }

        return $tag->id ?? null;
    }




    protected function addTagToQuestion($questionId, $tagId)
    {
        $qTag = new QuestionTag();
        $qTag->setDb($this->di->get("dbqb"));
        $qTag->questionId = $questionId;
        $qTag->tagId = $tagId;
        $qTag->save();

        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tag->find("id", $tagId);
        $tag->body = $tag->body;
        $tag->timesUsed+=1;
        $tag->save();
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
        $question->title  = $this->form->value("title");
        $question->body = $this->form->value("body");
        $question->user = $this->di->session->get("user");
        $question->created = date("Y-m-d H:i:s");
        $question->save();
        $this->questionId = $question->id;

        $newTagValue = $this->form->value("newTags");
        var_dump($newTagValue);
        if (!empty($newTagValue)) {
            $newTagList = explode(',', $newTagValue);
            foreach ($newTagList as $tag) {
                $tagId = $this->createTag(trim($tag), $question->id);
                if ($tagId != null) {
                    $this->addTagToQuestion($question->id, $tagId);
                }
            }
        }

        $tagValue = $this->form->value("tags");
        if (!empty($tagValue)) {
            foreach ($tagValue as $tag) {
                $this->addTagToQuestion($question->id, $tag);
            }
        }

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        if ($this-> questionId) {
            $this->di->get("response")->redirect("question/view-one/" . $this->questionId)->send();
        }
    }



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
