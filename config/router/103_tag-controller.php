<?php
/**
 * Mount the user controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "Taggar",
            "mount" => "tags",
            "handler" => "\Magm19\Tag\TagController",
        ],
    ]
];