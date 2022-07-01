<?php

use Tara\TestProject\Controllers\{
    IndexController,
    MaterialController,
    TagController,
    CategoryController
};

return [
    '~^$~' => [IndexController::class, 'index'],
    '~^material/create$~' => [MaterialController::class, 'create'],
    '~^tags/show$~' => [TagController::class, 'show'],
    '~^categories/show$~' => [CategoryController::class, 'show'],
    '~^material/find~' => [MaterialController::class, 'find'],
];
