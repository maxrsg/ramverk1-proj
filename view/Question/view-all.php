<?php

namespace Anax\View;
use Anax\TextFilter\TextFilter;


/**
 * View to display all questions.
 */


// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

$filter = new TextFilter();

// Create urls for navigation
$urlToCreate = url("question/create");
?><h1 class="heading">Alla frågor</h1>

<?php if (isset($_SESSION["user"])) : ?>
<p>
    <div class="answer-btn-wrap">
        <a href="<?= $urlToCreate ?>">Ställ ny fråga</a>
    </div>
</p>
<?php endif; ?>

<?php if (!$items) : ?>
    <p>Det finns inga frågor 😢</p>
<?php
    return;
endif;
?>

<div class="question-list-wrap">
    <?php foreach ($items as $item) : ?>
        <div class="question-wrap">
            <h4><a href="<?= url("question/view-one/{$item->id}"); ?>"><?= $item->title ?></a></h4>
            <p><?= $filter->markdown($item->body) ?></p>
        </div>
    </tr>
    <?php endforeach; ?>
</div>

