<?php

namespace Anax\View;

/**
 * User login view.
 */

// Create urls for navigation
$urlToCreate = url("user/create");



?><h1>Logga in</h1>

<?= $form ?>


<p>
    <a href="<?= $urlToCreate ?>">Skapa ny användare</a>
</p>