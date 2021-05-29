<?php

namespace Magm19\Tag;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Magm19\Question\Question;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagController implements ContainerInjectableInterface
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
    public function indexAction(): object
    {
        $page = $this->di->get("page");
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));

        $page->add("Tag/tags", [
            "tags" => $tag->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * view all questions connected to a tag
     *
     * @param int $id the id of the question.
     *
     * @return object as a response object
     */
    public function tagActionGet(int $id): object
    {
        $page = $this->di->get("page");
        $tag = new Tag();
        $questionTag = new QuestionTag();

        $tag->setDb($this->di->get("dbqb"));
        $user = $this->di->session->get("user");
        $questionTag->setDb($this->di->get("dbqb"));

        $selectedTag = $tag->findWhere("id = ?", $id);
        $questionIds = $questionTag->findAllWhere("tagId = ?", $tag->id);
        $isLoggedIn = isset($user);

        $questions = [];
        foreach ($questionIds as $questionId) {
            $question = new Question();
            $question->setDb($this->di->get("dbqb"));
            $questionToAdd = $question->findWhere("id = ?", $questionId->questionId);
            array_push($questions, $questionToAdd);
        }

        $page->add("Tag/tag", [
            "isLoggedIn" => $isLoggedIn,
            "tag" => $selectedTag,
            "questions" => $questions,
        ]);

        return $page->render([
            "title" => $tag->body ?? "Fråga",
        ]);
    }
}
