<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

return array(
    'scripts' => array(
        'cdn' => array(
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.3.2/dist/flasher-sweetalert.min.js',
        ),
        'local' => array(
            '/vendor/flasher/flasher-sweetalert.min.js',
        ),
    ),
    'styles' => array(
        'cdn' => array(
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.3.2/dist/flasher-sweetalert.min.css',
        ),
        'local' => array(
            '/vendor/flasher/flasher-sweetalert.min.css',
        ),
    ),
);

// return [
//     'plugins' => [
//         'sweetalert' => [
//             'scripts' => [
//                 '/vendor/flasher/sweetalert2.min.js',
//                 '/vendor/flasher/flasher-sweetalert.min.js',
//             ],
//             'styles' => [
//                 '/vendor/flasher/sweetalert2.min.css',
//             ],
//             'options' => [
//                 // Optional: Add global options here
//                 'position' => 'center'
//             ],
//         ],
//     ],
// ];
