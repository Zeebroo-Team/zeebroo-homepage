<?php

/*
| Sinhala validation messages for the public website's forms (the contact form).
| Any rule not listed here falls back to Laravel's English message.
*/

return [

    'required' => ':attribute අවශ්‍යයි.',
    'string' => ':attribute පාඨයක් විය යුතුයි.',
    'email' => 'වලංගු ඊමේල් ලිපිනයක් ඇතුළත් කරන්න.',
    'in' => 'තෝරාගත් :attribute වලංගු නැත.',
    'min' => [
        'string' => ':attribute අවම වශයෙන් අකුරු :min ක් විය යුතුයි.',
    ],
    'max' => [
        'string' => ':attribute අකුරු :max කට වඩා වැඩි නොවිය යුතුයි.',
    ],

    'attributes' => [
        'name' => 'සම්පූර්ණ නම',
        'email' => 'ඊමේල්',
        'phone' => 'දුරකථනය',
        'business' => 'ව්‍යාපාරයේ නම',
        'topic' => 'මාතෘකාව',
        'message' => 'පණිවිඩය',
    ],

];
