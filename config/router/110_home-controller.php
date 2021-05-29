<?php

/**
 * Mount the user controller onto a mountpoint.
 */

return [
    "routes" => [
        [
            "info" => "Hem",
            "mount" => "home",
            "handler" => "\Magm19\Home\HomeController",
        ],
    ]
];
