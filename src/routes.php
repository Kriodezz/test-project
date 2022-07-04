<?php

use Tara\TestProject\Controllers\{
    IndexController,
    MaterialController,
    TagController,
    CategoryController
};

return [
    '~^$~' => [IndexController::class, 'index'],
    '~^material/find$~' => [MaterialController::class, 'find'],
    '~^material/show/(\d+)$~' => [MaterialController::class, 'show'],
    '~^material/create$~' => [MaterialController::class, 'create'],
    '~^tags/show$~' => [TagController::class, 'show'],
    '~^tags/create$~' => [TagController::class, 'create'],
    '~^tags/edit/(\d+)$~' => [TagController::class, 'edit'],
    '~^tags/add-to/(\d+)$~' => [TagController::class, 'addTo'],
    '~^tags/delete/(\d+)$~' => [TagController::class, 'delete'],
    '~^tag/(.+)/delete/(\d+)$~' => [TagController::class, 'deleteFromMaterial'],
    '~^find/tag/(.+)$~' => [TagController::class, 'findByTag'],
    '~^categories/show$~' => [CategoryController::class, 'show'],
    '~^categories/create~' => [CategoryController::class, 'create'],
];
