<?php

use Tara\TestProject\Controllers\{
    IndexController,
    ArticleController,
    TagController,
    CategoryController
};

return [
    '~^$~' => [IndexController::class, 'index'],
    '~^articles/create$~' => [ArticleController::class, 'create'],
    '~^tags/show$~' => [TagController::class, 'show'],
    '~^categories/show$~' => [CategoryController::class, 'show'],
];
