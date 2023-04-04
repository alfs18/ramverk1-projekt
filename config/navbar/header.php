<?php
if ($_SESSION["acronym"] ?? null) {
    $status = $_SESSION["status"];
    $questions = [
        "text" => "Frågor",
        "url" => "user/questions",
        "title" => "Frågor",
        "submenu" => [
            "items" => [
                [
                    "text" => "Ställ fråga",
                    "url" => "user/ask",
                    "title" => "Ställ fråga",
                ],
                [
                    "text" => "Se ställda frågor",
                    "url" => "user/showQuestions",
                    "title" => "Alla frågor",
                ],
            ],
        ],
    ];
} else {
    $status = [
        "text" => "Logga in",
        "url" => "user/login",
        "title" => "Logga in",
    ];
    $questions = [
        "text" => "Frågor",
        "url" => "user/questions",
        "title" => "Se ställda frågor",
    ];
}


/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats",
        ],
        // [
        //     "text" => "Styleväljare",
        //     "url" => "style",
        //     "title" => "Välj stylesheet.",
        // ],
        // [
        //     "text" => "Frågor",
        //     "url" => "questions",
        //     "title" => "Se ställda frågor",
        // ],
        $questions ?? null,
        $status ?? null,
    ],
];
