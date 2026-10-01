<?php

/*
|--------------------------------------------------------------------------
| Capabilities
|--------------------------------------------------------------------------
|
| The lab runs three capabilities. This file is the single source of truth for
| their slugs and labels: the contact form renders its select from here, the
| form request validates against it, and the admin panel labels it. Adding a
| capability means adding it here and nowhere else.
|
| Order is the display order on the services page and the contact form.
|
*/

return [

    'cyber' => [
        'slug' => 'cyber',
        'label' => 'Cybersecurity',
        'blurb' => 'Offensive and defensive security',
    ],

    'software' => [
        'slug' => 'software',
        'label' => 'Software Engineering',
        'blurb' => 'Applications, APIs and products',
    ],

    'three_d' => [
        'slug' => 'three_d',
        'label' => 'Creative Technology',
        'blurb' => 'Animation, motion design and frontend development',
    ],

];
