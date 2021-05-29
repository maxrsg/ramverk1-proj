<?php

namespace Magm19\Home;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Magm19\Question\Question;
use Magm19\Tag\Tag;
use Magm19\User\User;

class HomeController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize(): void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction()
    {
        $page = $this->di->get("page");
        $question = new Question();
        $tag = new Tag();
        $user = new User();

        $question->setDb($this->di->get("dbqb"));
        $tag->setDb($this->di->get("dbqb"));
        $user->setDb($this->di->get("dbqb"));

        $questions = $question->findAll();
        $tags = $tag->findAll();

        $questions = $this->sortAndSlice($questions, "question");
        $tags = $this->sortAndSlice($tags, "tag");

        $page->add("Page/Home", [
            "questions" => $questions,
            "tags" => $tags,
        ]);

        return $page->render(["title" => "Hem"]);
    }



    /**
     * helper function that uses usort to sort an array of tag/question objects
     * after a specific property and then slices it.
     * @return array containing five first elements after sort
     */
    private function sortAndSlice($array, $for)
    {
        if ($for === "question") {
            usort($array, function ($objA, $objB) {
                return (($objA->created > $objB->created) ? -1 : 1);
            });
        } else if ($for === "tag") {
            usort($array, function ($objA, $objB) {
                return (($objA->timesUsed > $objB->timesUsed) ? -1 : 1);
            });
        }

        return array_slice($array, 0, 5);
    }
}
