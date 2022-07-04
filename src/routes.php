<?php

/*
 * Роутинг
 */

use Tara\TestProject\Controllers\{
    IndexController,
    MaterialController,
    TagController,
    CategoryController
};

return [
    //Отображение страницы с материалами и поиском
    '~^$~' => [IndexController::class, 'index'],
    //Поиск
    '~^materials/find$~' => [MaterialController::class, 'find'],
    //Отображение одного материала
    '~^material/show/(\d+)$~' => [MaterialController::class, 'show'],
    //Создание нового материала
    '~^material/create$~' => [MaterialController::class, 'create'],
    //Редактирование материала
    '~^material/edit/(\d+)$~' => [MaterialController::class, 'edit'],
    //Удаление материала
    '~^material/delete/(\d+)$~' => [MaterialController::class, 'delete'],
    //Отображение страницы с тегами
    '~^tags/show$~' => [TagController::class, 'show'],
    //Создание нового тега
    '~^tags/create$~' => [TagController::class, 'create'],
    //Редактирование тега
    '~^tags/edit/(\d+)$~' => [TagController::class, 'edit'],
    //Добавление значения тега к материалу
    '~^tags/add-to/(\d+)$~' => [TagController::class, 'addTo'],
    //Удаление значения тега из материала
    '~^tag/(.+)/delete/(\d+)$~' => [TagController::class, 'deleteFromMaterial'],
    //Удаление тега
    '~^tags/delete/(\d+)$~' => [TagController::class, 'delete'],
    //Поиск по id тега
    '~^find/tag/(.+)$~' => [TagController::class, 'findByTag'],
    //Отображение страницы с категориями
    '~^categories/show$~' => [CategoryController::class, 'show'],
    //Создание новой категории
    '~^categories/create$~' => [CategoryController::class, 'create'],
    //Редактирование категории
    '~^categories/edit/(\d+)$~' => [CategoryController::class, 'edit'],
    //Удаление категории
    '~^categories/delete/(\d+)$~' => [CategoryController::class, 'delete'],
];
