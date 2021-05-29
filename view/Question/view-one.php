<?php

/**
 * View a specific question
 */

namespace Anax\View;

use Magm19\Comment\CommentController;
use Magm19\User\UserController;
use Anax\TextFilter\TextFilter;

$commentController = new CommentController();
$userController = new UserController();
$filter = new TextFilter();
$urlToView = url("question");
$urlToUser = url("user/view");
$urlToTag = url("tags/tag");
$answerCount = 0;
?>

<?php if ($question) :
    $urlToAnswer = url("answer/create/" . $question->id);
    ?>
    <h1 class="heading"><?= $question->title ?></h1>
    <div class="big-question-wrap">
        <div class="question-content">
            <p><?= $filter->markdown($question->body) ?></p>
            <div class="tag-wrap">
                <?php foreach ($tags as $tag) :?>
                    <p class="tag">
                        <a href="<?= $urlToTag . "/" . $tag->id ?>"><?= $tag->body ?></a>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="userbox-footer">
            <p><?= $question->created ?></p>
            <div class="userbox-wrap">
                <img src="<?= $userController->getGravatarLink($question->user, $this->di, 40); ?>">
                <p>
                    <a href="<?= $urlToUser . "/" . $question->user?>"><?= $question->user ?></a>
                </p>
            </div>
        </div>
    </div>
    <?php if ($isLoggedIn) : ?>
    <div class="answer-btn-wrap">
        <div>
            <a href="<?= $urlToAnswer ?>"> Svara </a>
        </div>
    </div>
    <?php endif;
    foreach ($questionComments as $comment) :?>
        <div class="question-comment-wrap" id="<?= "question-" . $question->id . "-comment-" . $comment->id ?>">
            <p><?= $filter->markdown($comment->body) ?></p>
            <div class="comment-footer">
                <div class="comment-userbox-wrap userbox-wrap">
                    <img src="<?= $userController->getGravatarLink($comment->user, $this->di, 40); ?>">
                    <p>
                        <a href="<?= $urlToUser . "/" . $comment->user?>"><?= $comment->user ?></a>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($isLoggedIn) : ?>
        <?= $commentFormQuestion ?>
    <?php endif; ?>
    <?php
endif;
?>

<?php if ($answers) :
    foreach ($answers as $answer) : ?>
    <div class="big-question-wrap" id="<?= "question-" . $question->id . "-answer-" . $answer->id ?>">
        <div class="question-content">
            <p><?= $filter->markdown($answer->body) ?></p>
        </div>
        <div class="userbox-footer">
            <p><?= $question->created ?></p>
            <div class="userbox-wrap">
                <img src="<?= $userController->getGravatarLink($answer->user, $this->di, 40); ?>">
                <p>
                    <a href="<?= $urlToUser . "/" . $answer->user?>"><?= $answer->user ?></a>
                </p>
            </div>
        </div>
    </div>
        <?php   foreach ($answerComments[$answerCount] as $comment) :?>
            <div class="question-comment-wrap" id="<?= "question-" . $question->id . "-comment-" . $comment->id ?>">
                <p><?= $filter->markdown($comment->body) ?></p>
                <div class="comment-footer">
                    <div class="comment-userbox-wrap userbox-wrap">
                        <img src="<?= $userController->getGravatarLink($comment->user, $this->di, 40); ?>">
                        <p>
                            <a href="<?= $urlToUser . "/" . $comment->user?>"><?= $comment->user ?></a>
                        </p>
                    </div>
                </div>
            </div>
        <?php   endforeach;
        $answerCount++;
        $commentForm = $commentController->createAnswerForm($this->di, $answer->id, $question->id);
        if ($isLoggedIn) {
            echo $commentForm;
        }
    endforeach;
endif;
?>

<p>
    <a href="<?= $urlToView ?>">Alla frågor</a>
</p>
