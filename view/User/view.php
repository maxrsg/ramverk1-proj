<?php

namespace Anax\View;

/**
 * User login view.
 */

// Create urls for navigation
$urlToView = url("question/view-one");

if(isset($username)) :
    ?><h1>Användare: <?= $username ?></h1>
    <p>Medlem sedan: <?= $created ?></p>
    <div class="user-questions">
        <h3>Frågor: </h3>
        <?php foreach ($questions as $question): ?>
            <div class="question-title-wrap">
                <h4 class="question-title-h4">
                    <a href="<?= $urlToView . "/" . $question->id ?>"><?= $question->title ?></a>
                </h4>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="user-questions">
        <h3>Svar: </h3>
        <?php foreach ($answers as $answer): ?>
            <div class="question-title-wrap">
                <h4 class="question-title-h4">
                    <a href="<?= $urlToView . "/" . $question->id . "#question-" . $question->id . "-answer-" . $answer->id ?>"><?= $answer->body ?></a>
                </h4>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="user-questions">
        <h3>Kommentrarer: </h3>
        <?php foreach ($comments as $comment): ?>
            <div class="question-title-wrap">
                <h4 class="question-title-h4">
                    <a href="<?= $urlToView . "/" . $comment->id ?>"><?= $comment->body ?></a>
                </h4>
            </div>
        <?php endforeach; ?>
    </div>
<?php  else : ?>
    <h1>Användaren kunde inte hittas!</h1>
<?php endif; ?>