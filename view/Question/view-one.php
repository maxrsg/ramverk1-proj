<?php

namespace Anax\View;

/**
 * View a specific question
 */

// Gather incoming variables and use default values if not set
$item = isset($item) ? $item : null;

// Create urls for navigation
$urlToView = url("question");
// var_dump($question);
?>

<?php if ($question) : 
    $urlToAnswer = url("answer/create/" . $question->id);
?>
    <h1><?= $question->title ?></h1>
    <div class="big-question-wrap">
        <p><?= $question->body ?></p>
        <p>Frågad av: <?= $question->user ?></p>
        <p>
            <a href="<?= $urlToAnswer ?>">Svara</a>
        </p>
    </div>
<?php
    // return;
endif;
?>

<?php if ($answers) : 
// var_dump($answers);
    $urlToAnswer = url("answer/create/" . $question->id);
    foreach ($answers as $answer) :
        // var_dump($answer);
?>
    <div class="answer-wrap">
        <p><?= $answer->body ?></p>
    </div>
<?php
    // return;
    endforeach;
endif;
?>

<p>
    <a href="<?= $urlToView ?>">Alla frågor</a>
</p>
