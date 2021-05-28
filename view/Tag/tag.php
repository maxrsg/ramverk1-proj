<?php

namespace Anax\View;

$urlToView = url("question/view-one");
?>

<h1>Alla frågor för taggen: <?= $tag->body ?></h1>

<div class="all-titles-wrap">
    <?php foreach ($questions as $question) : ?>
        <div class="question-title-wrap">
            <h4 class="question-title-h4">
                <a href="<?= $urlToView . "/" . $question->id ?>"><?= $question->title ?></a>
            </h4>
        </div>
    <?php endforeach; ?>
</div>