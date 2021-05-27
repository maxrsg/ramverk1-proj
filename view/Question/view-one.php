<?php

namespace Anax\View;
use Magm19\Comment\CommentController;
use Magm19\User\UserController;

/**
 * View a specific question
 */
$commentController = new CommentController();
$userController = new UserController();
// Gather incoming variables and use default values if not set
$item = isset($item) ? $item : null;

// Create urls for navigation
$urlToView = url("question");
// var_dump($answerComments);
// var_dump($tags);
$answerCount = 0;
?>

<?php if ($question) : 
    $urlToAnswer = url("answer/create/" . $question->id);
?>
    <h1><?= $question->title ?></h1>
    <div class="big-question-wrap">
        <p><?= $question->body ?></p>
        <?php foreach ($tags as $tag):?>
            <p><?= $tag->body ?></p>
        <?php endforeach; ?>
        <div class="userbox-wrap">
            <p>Frågad av: <?= $question->user ?></p>
            <img src="<?= $userController->getGravatarLink($question->user, $this->di); ?>">
        </div>
        <p>
            <a href="<?= $urlToAnswer ?>">Svara</a>
        </p>
    </div>
    <?php foreach ($questionComments as $comment):?>
        <div class="question-comment-wrap">
            <p><?= $comment->body ?></p>
            <p><?= $comment->user ?></p>
            <img src="<?= $userController->getGravatarLink($comment->user, $this->di); ?>">
        </div>
    <?php endforeach; ?>
    <?= $commentFormQuestion ?>
<?php
endif;
?>

<?php if ($answers) : 
    $urlToAnswer = url("answer/create/" . $question->id);
    foreach ($answers as $answer) : ?>
    <div class="answer-wrap">
        <p><?= $answer->body ?></p>
        <p><?= $answer->user ?></p>
        <img src="<?= $userController->getGravatarLink($answer->user, $this->di); ?>">
    </div>
<?php   foreach ($answerComments[$answerCount] as $comment):?>
            <div class="question-comment-wrap">
                <p><?= $comment->body ?></p>
                <p><?= $comment->user ?></p>
                <img src="<?= $userController->getGravatarLink($comment->user, $this->di); ?>">
            </div>
<?php   endforeach;
        $answerCount++;
        $commentForm = $commentController->createAnswerForm($this->di, $answer->id);
        echo $commentForm;
    endforeach;
endif;
?>

<p>
    <a href="<?= $urlToView ?>">Alla frågor</a>
</p>
