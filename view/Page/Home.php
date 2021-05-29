<?php

namespace Anax\View;
use Anax\TextFilter\TextFilter;
use Magm19\User\UserController;

$filter = new TextFilter();
$userController = new UserController();
$urlToUser = url("user/view");

if (isset($logoutMessage)) : ?>
    <p><?= $logoutMessage ?></p>
<?php
endif; ?>
<h1 class="heading">Välkommen till: Allt om klockor!</h1>

<div class="home-main-wrap">
    <div class="home-all-question">
        <h2> Senaste frågorna:</h2>
        <?php foreach ($questions as $question) : ?>
            <div class="home-question-wrap">
                <div class="question-wrap">
                    <h4><a href="<?= url("question/view-one/{$question->id}"); ?>"><?= $question->title ?></a></h4>
                    <p><?= $filter->markdown($question->body) ?></p>
                </div>
                <div class="home-user-wrap">
                    <div class="userbox-wrap">
                        <img src="<?= $userController->getGravatarLink($question->user, $this->di, 80); ?>">
                        <p>
                            <a href="<?= $urlToUser . "/" . $question->user?>"><?= $question->user ?></a>
                        </p>
                    </div>
                    <p><?= $question->created ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="home-all-tags">
        <h2> Populäraste taggarna: </h2>
        <div class="all-tags-wrap">
            <?php foreach ($tags as $tag) : ?>
                <div class="tag-wrap">
                    <p class="tag">
                        <a href="<?= url("tags/tag/{$tag->id}"); ?>"><?= $tag->body ?></a>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>