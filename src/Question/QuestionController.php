<?php

namespace Magm19\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Magm19\Question\HTMLForm\CreateForm;
use Magm19\Question\HTMLForm\EditForm;
use Magm19\Question\HTMLForm\DeleteForm;
use Magm19\Question\HTMLForm\UpdateForm;
use Magm19\Answer\Answer;
use Magm19\Tag\QuestionTag;
use Magm19\Tag\Tag;
use Magm19\Comment\Comment;
use Magm19\Comment\HTMLForm\CreateCommentForm;
use Magm19\Comment\HTMLForm\CreateAnswerCommentForm;
// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $page->add("Question/view-all", [
            "items" => $question->findAll(),
        ]);

        return $page->render([
            "title" => "Alla frågor",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();
        $user = $this->di->session->get("user");

        if(isset($user)) {
            $page->add("Question/create", [
                "form" => $form->getHTML(),
            ]);
        } else {
            return $this->indexActionGet();
        }

        return $page->render([
            "title" => "Skapa ny fråga",
        ]);
    }



    /**
     * view one question with all answers/comments/tags
     *
     * @param int $id the id of the question.
     *
     * @return object as a response object
     */
    public function viewOneAction(int $id) : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $answer = new Answer();
        $questionTag = new QuestionTag();
        $comment = new Comment();
        $commentFormQuestion = new CreateCommentForm($this->di, $id);
        $commentFormAnswer= new CreateAnswerCommentForm($this->di, $id, $id);
        $user = $this->di->session->get("user");

        $question->setDb($this->di->get("dbqb"));
        $answer->setDb($this->di->get("dbqb"));
        $questionTag->setDb($this->di->get("dbqb"));
        $comment->setDb($this->di->get("dbqb"));
        $commentFormQuestion->check();
        $commentFormAnswer->check();

        $question->find("id", $id);
        $allAnswers = $answer->findAllWhere("questionId = ?", [$id]);
        $allTagIds = $questionTag->findAllWhere("questionId = ?", $question->id);
        $questionComments = $comment->findAllWhere("parentId = ? AND parentIsAnswer = ?", [$id, 0]);
        $isLoggedIn = isset($user);

        $answerComments = [];
        foreach ($allAnswers as $answer) {
            $comments = $comment->findAllWhere("parentId = ? AND parentIsAnswer = ?", [$answer->id, 1]);
            array_push($answerComments, $comments);
        }

        $questionTags = [];
        foreach ($allTagIds as $tagId) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $qTag = $tag->findWhere("id = ?", $tagId->tagId);
            array_push($questionTags, $qTag);
        }

        $page->add("Question/view-one", [
            "question" => $question,
            "answers" => $allAnswers,
            "tags" => $questionTags,
            "questionComments" => $questionComments,
            "answerComments" => $answerComments,
            "commentFormQuestion" => $commentFormQuestion->getHTML(),
            "commentFormAnswer" => $commentFormAnswer->getHTML(),
            "isLoggedIn" => $isLoggedIn,
        ]);

        return $page->render([
            "title" => $question->title ?? "Fråga",
        ]);
    }
}
