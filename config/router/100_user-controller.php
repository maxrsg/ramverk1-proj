<?php
/**
 * Mount the user controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "User controller.",
            "mount" => "user",
            "handler" => "\Magm19\User\UserController",
        ],
    ]
];