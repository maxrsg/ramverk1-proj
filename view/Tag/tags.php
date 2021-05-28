<?php

namespace Anax\View;

?>

<h1>Alla taggar</h1>

<div class="all-tags-wrap">
    <?php foreach ($tags as $tag) : ?>
        <div class="tag-wrap">
            <p class="tag">
                <a href="tags/tag/<?= $tag->id ?>"><?= $tag->body ?></a>
            </p>
        </div>
    <?php endforeach; ?>
</div>