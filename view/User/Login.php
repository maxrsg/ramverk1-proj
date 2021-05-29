<?php

/**
 * User login view.
 */

 namespace Anax\View;

// Create urls for navigation
$urlToCreate = url("user/create");

?><h1>Logga in</h1>

<?= $form ?>


<p>
    <a href="<?= $urlToCreate ?>">Skapa ny användare</a>
</p>