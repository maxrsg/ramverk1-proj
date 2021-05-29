<?php

/**
 * User login view.
 */

namespace Anax\View;

use Magm19\User\UserController;

$userController = new UserController();
$urlToView = url("question/view-one");

if (isset($username)) :
    ?><h1>Användare: <?= $username ?></h1>
    <img src="<?= $userController->getGravatarLink($username, $this->di, 80); ?>">
    <p>Medlem sedan: <?= $created ?></p>
    <div class="user-questions">
        <?php if ($questions) :?>
            <h3>Frågor: </h3>
            <?php foreach ($questions as $question) : ?>
                <div class="question-title-wrap">
                    <h4 class="question-title-h4">
                        <a href="<?= $urlToView . "/" . $question->id ?>"><?= $question->title ?></a>
                    </h4>
                </div>
            <?php endforeach; ?>
        <?php  endif; ?>
    </div>

    <div class="user-questions">
        <?php if ($answers) :?>
            <h3>Svar: </h3>
            <?php foreach ($answers as $answer) : ?>
                <div class="question-title-wrap">
                    <h4 class="question-title-h4">
                        <a href="<?= $urlToView . "/" . $answer->questionId . "#question-" . $answer->questionId . "-answer-" . $answer->id ?>"><?= $answer->body ?></a>
                    </h4>
                </div>
            <?php endforeach; ?>
        <?php  endif; ?>
    </div>

    <div class="user-questions">
        <?php if ($comments) :?>
            <h3>Kommentrarer: </h3>
            <?php foreach ($comments as $comment) : ?>
                <div class="question-title-wrap">
                    <h4 class="question-title-h4">
                        <a href="<?= $urlToView . "/" . $comment->questionId . "#question-" . $comment->questionId . "-answer-" . $comment->id ?>"><?= $comment->body ?></a>
                    </h4>
                </div>
            <?php endforeach; ?>
        <?php  endif; ?>
    </div>
<?php  else : ?>
    <h1>Användaren kunde inte hittas!</h1>
<?php endif; ?>