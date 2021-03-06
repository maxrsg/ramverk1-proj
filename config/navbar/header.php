<?php

/**
 * Supply the basis for the navbar as an array.
 */

$user = $_SESSION['user'] ?? null;

if ($user) {
    $items = [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Frågor",
            "url" => "question",
            "title" => "Alla frågor"
        ],
        [
            "text" => "Taggar",
            "url" => "tags",
            "title" => "Visa alla taggar",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Profil",
            "url" => "user",
            "title" => "Gå till din profil",
        ],
    ];
} else {
    $items = [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Frågor",
            "url" => "question",
            "title" => "Alla frågor"
        ],
        [
            "text" => "Taggar",
            "url" => "tags",
            "title" => "Visa alla taggar",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Logga in",
            "url" => "user/login",
            "title" => "Logga in",
        ],
    ];
}
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
    // Here comes the menu items
    "items" => $items,
];
