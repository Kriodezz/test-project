<?php

use Tara\TestProject\Controllers\{
    IndexController,
    MaterialController,
    TagController,
    CategoryController
};

return [
    '~^$~' => [IndexController::class, 'index'],
    '~^material/find~' => [MaterialController::class, 'find'],
    '~^material/show/(\d+)$~' => [MaterialController::class, 'show'],
    '~^material/create$~' => [MaterialController::class, 'create'],
    '~^tags/show$~' => [TagController::class, 'show'],
    '~^tags/add-to/(\d+)$~' => [TagController::class, 'addTo'],
    '~^tag/(.+)/delete/(\d+)$~' => [TagController::class, 'delete'],
    '~^find/tag/(.+)$~' => [TagController::class, 'findByTag'],
    '~^categories/show$~' => [CategoryController::class, 'show'],
];
