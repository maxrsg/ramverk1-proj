<?php

/**
 * View to create a new book.
 */

namespace Anax\View;

// Create urls for navigation
$urlToViewItems = url("book");

?><h1>Ställ en ny fråga</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToViewItems ?>">Alla frågor</a>
</p>
