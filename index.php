<?php

$dummyData = [
    [
        "taskName" => "Todo harkka",
        "responsible" => "koppava",
        "deadline" => "in two days",
        "done" => 0
    ],
    [
        "taskName" => "Maailman valloitus",
        "responsible" => "Suuri Johtaja",
        "deadline" => "in two years",
        "done" => 0
    ],
    [
        "taskName" => "Kuussa käyminen",
        "responsible" => "Neil Armstrong",
        "deadline" => "35 years ago",
        "done" => 1
    ],
    [
        "taskName" => "Asiat joita lykkäsit huomiselle",
        "responsible" => "Joku muu",
        "deadline" => "yesterday",
        "done" => 0
    ],
    [
        "taskName" => "Sähkölaskun maksaminen",
        "responsible" => "Kämppis",
        "deadline" => "next week",
        "done" => 1
    ],
    [
        "taskName" => "Aurinkokunnan tuhoaminen",
        "responsible" => "Aurinko",
        "deadline" => "in ten billion years",
        "done" => 0
    ]
];

echo json_encode($dummyData);