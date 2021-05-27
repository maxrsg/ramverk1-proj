<?php

namespace Anax\View;
use Magm19\User\UserController;
/**
 * User login view.
 */

if (isset($userData)) :
$urlToEdit = url("user/update/" . $userData->id);
$urlToLogout = url("user/logout");
// $default = "http://www.student.bth.se/~magm19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/image/leaf.jpg";
// $size = 80;
// $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $userData->email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
$userController = new UserController();
$gravatar = $userController->getGravatarLink($userData->username, $this->di);
?><h1>Din profil</h1>

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
    <a href="<?= $urlToEdit ?>">Uppdatera din profil</a>
</p>

<p>
    <a href="<?= $urlToLogout ?>">Logga ut</a>
</p>

<?php endif; ?>