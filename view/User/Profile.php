<?php

/**
 * User login view.
 */

namespace Anax\View;

use Magm19\User\UserController;

if ($isLoggedIn) :
    $urlToEdit = url("user/update/" . $userData->id);
    $urlToLogout = url("user/logout");
    $urlToView = url("user/view/" .$userData->id);
    $urlToDelete = url("question/delete");
    $userController = new UserController();
    $gravatar = $userController->getGravatarLink($userData->username, $this->di);
    ?>
    <h1>Din profil</h1>

    <div class="profile-wrap">
        <p>Användarnamn: <?= $userData->username?></p>
        <p>Email: <?= $userData->email?></p>
        <p>Kontot skapat: <?= $userData->created?></p>
        <?php if (isset($userData->updated)) :?>
            <p>Senaste uppdatdering: <?= $userData->updated?></p>
        <?php endif; ?>
        <img src="<?= $gravatar ?>" alt="">
    </div>

    <p>
        <a href="<?= $urlToView ?>">Se din profil som den visas för andra</a>
    </p>

    <p>
        <a href="<?= $urlToEdit ?>">Uppdatera din profil</a>
    </p>

    <p>
        <a href="<?= $urlToLogout ?>">Logga ut</a>
    </p>

    <div class="delete-wrap">
        <a href="<?=  $urlToDelete ?>">Radera frågor</a>
    </div>

<?php endif; ?>