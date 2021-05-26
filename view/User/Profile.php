<?php

namespace Anax\View;

/**
 * User login view.
 */

if (isset($userData)) :
$urlToEdit = url("user/update/" . $userData->id);

?><h1>Din profil</h1>

<div class="profile-wrap">
    <p>Användarnamn: <?= $userData->username?></p>
    <p>Email: <?= $userData->email?></p>
    <p>Kontot skapat: <?= $userData->created?></p>
    <?php if (isset($userData->updated)) :?>
        <p>Senaste uppdatdering: <?= $userData->updated?></p>
    <?php endif; ?>
</div>


<p>
    <a href="<?= $urlToEdit ?>">Uppdatera din profil</a>
</p>

<?php endif; ?>