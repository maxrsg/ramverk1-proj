<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("question/create");
$urlToDelete = url("question/delete");



?><h1>Alla frågor</h1>

<p>
    <a href="<?= $urlToCreate ?>">Create</a> | 
    <a href="<?= $urlToDelete ?>">Delete</a>
</p>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
<?php
    return;
endif;
?>

<div class="question-list-wrap">
    <?php foreach ($items as $item) : ?>
        <div class="question-wrap">
            <h4><a href="<?= url("question/view-one/{$item->id}"); ?>"><?= $item->title ?></a></h4>
            <!-- <?= $item->title ?> -->
            <p><?= $item->body ?></p>
        </div>
    </tr>
    <?php endforeach; ?>
</div>

