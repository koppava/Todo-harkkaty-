<?php

$dummyData = [
    "tasks" => [
        [
            "taskName" => "Todo harkka",
            "assignee" => "koppava",
            "deadline" => "in two days",
            "done" => 0
        ],
        [
            "taskName" => "Maailman valloitus",
            "assignee" => "Suuri Johtaja",
            "deadline" => "in two years",
            "done" => 0
        ],
        [
            "taskName" => "Kuussa käyminen",
            "assignee" => "Neil Armstrong",
            "deadline" => "35 years ago",
            "done" => 1
        ],
        [
            "taskName" => "Asiat joita lykkäsit huomiselle",
            "assignee" => "Joku muu",
            "deadline" => "yesterday",
            "done" => 0
        ],
        [
            "taskName" => "Sähkölaskun maksaminen",
            "assignee" => "Kämppis",
            "deadline" => "next week",
            "done" => 1
        ],
        [
            "taskName" => "Aurinkokunnan tuhoaminen",
            "assignee" => "Aurinko",
            "deadline" => "in ten billion years",
            "done" => 0
        ]
    ]
];

echo json_encode($dummyData);