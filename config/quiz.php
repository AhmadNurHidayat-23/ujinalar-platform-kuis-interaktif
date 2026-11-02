<?php

return [
    'pengetahuan-umum' => [
        'name' => 'Pengetahuan Umum',
        'description' => 'Jelajahi dunia, sejarah, dan hal-hal menarik di sekitar kita.',
        'label' => 'Dunia & wawasan',
        'questions' => require __DIR__.'/questions/umum.php',
    ],
    'teknologi' => [
        'name' => 'Teknologi',
        'description' => 'Kenali cara kerja teknologi yang menemani keseharianmu.',
        'label' => 'Digital & inovasi',
        'questions' => require __DIR__.'/questions/teknologi.php',
    ],
    'sains' => [
        'name' => 'Sains',
        'description' => 'Temukan penjelasan di balik alam dan kehidupan.',
        'label' => 'Alam & penemuan',
        'questions' => require __DIR__.'/questions/sains.php',
    ],
];
