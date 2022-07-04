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
                header('Location: /categories/show');
                exit();
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        $this->view->renderHtml(
            'create-category.php',
            [
                'title' => 'Категории',
                'action' => '/category/create',
                'act' => 'Добавить',
                'button' => 'Добавить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    public function edit($idCategory)
    {
        $category = Category::findByIdInObject($idCategory);
var_dump($category); var_dump($_POST);
        if ($category === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Такой категории нет!',
                    'description' => 'Вы выбрали неправильную категорию.'
                ],
                404);
            exit();
        }

        if (!empty($_POST)) {
            try {
                $category->updateCategory($_POST);
                header('Location: /categories/show');
                exit();
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        $this->view->renderHtml(
            'create-category.php',
            [
                'title' => 'Категории',
                'category' => $category,
                'action' => '/category/edit/' . $idCategory,
                'act' => 'Редактировать',
                'button' => 'Изменить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    public function delete($idCategory)
    {
        $category = Category::findByIdInObject($idCategory);
        $category->deleteRelations();
        $category->delete();
        header('Location: /categories/show');
    }
}
