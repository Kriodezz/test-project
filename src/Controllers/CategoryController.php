<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Models\Category;

class CategoryController extends AbstractController
{
    public function show()
    {
        $allCategory = Category::findAllInObject();

        $this->view->renderHtml(
            'list-category.php',
            ['title' => 'Категории', 'categories' => $allCategory]);
    }

    public function create()
    {
        if (!empty($_POST)) {
            try {
                Category::createCategory($_POST);
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        $this->view->renderHtml(
            'create-category.php',
            [
                'title' => 'Категории',
                'action' => '/categories/create',
                'act' => 'Добавить',
                'button' => 'Добавить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }
}
