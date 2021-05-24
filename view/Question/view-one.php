<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$item = isset($item) ? $item : null;

// Create urls for navigation
$urlToView = url("book");

// var_dump($question);

?>
<!-- <h1>Redigera fråga</h1> -->

<?php if ($question) : ?>
    <h1><?= $question->title ?></h1>
    <p><?= $question->body ?></p>
<?php
    return;
endif;
?>

<p>
    <a href="<?= $urlToView ?>">Alla frågor</a>
</p>
