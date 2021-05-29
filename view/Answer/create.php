<?php

/**
 * View to create a new book.
 */

 namespace Anax\View;

use Anax\TextFilter\TextFilter;

$filter = new TextFilter();
$urlBackToQuestion = url("question/view-one/" . $question->id);

if ($isLoggedIn) :
    ?><h1>Svara på frågan: <?= $question->title ?></h1>

<div class="question-to-be-asnwered-wrap">
    <?= $filter->markdown($question->body) ?>
</div>
    <?= $form ?>

<?php endif; ?>
<p>
    <a href="<?= $urlBackToQuestion ?>">Tillbaka till frågan</a>
</p>
