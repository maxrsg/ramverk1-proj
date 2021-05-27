<?php

namespace Anax\View;

?>

<h1>Alla taggar</h1>

<?php foreach ($tags as $tag) : ?>

    <p><?= $tag->body ?></p>

<?php endforeach; ?>