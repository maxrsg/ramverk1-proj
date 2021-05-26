<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlBackToQuestion = url("question/view-one/" . $question->id);

// var_dump($question);

?><h1>Svara på frågan: <?= $question->title ?></h1>

<div class="question-to-be-asnwered-wrap">
    <?= $question->body ?>
</div>
<?= $form ?>

<p>
    <a href="<?= $urlBackToQuestion ?>">Tillbaka till frågan</a>
</p>
