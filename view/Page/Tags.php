<?php

namespace Anax\View;

?>

<h1>Alla taggar</h1>

<?php foreach ($tags as $tag) : ?>

    <div class="tag-wrap">
        <p class="tag"><?= $tag->body ?></p>
    </div>

<?php endforeach; ?>