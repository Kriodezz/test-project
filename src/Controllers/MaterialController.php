<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Models\Category;
use Tara\TestProject\Models\MaterialWithAllData;
use Tara\TestProject\Models\Tag;

class MaterialController extends AbstractController
{
    /*
     * Поиск материалов
     */
    public function find()
    {
        if (!empty($_POST['data-from-user'])) {
// ------------------------------- find

//----------------------------------------------------------------
            $this->view->renderHtml(
                'list-materials.php',
                ['title' => 'Материалы']);
        } else {
            header('Location: /');
        }
    }

    /*
     * Отображение одного материала
     */
    public function show($idMaterial)
    {
        //Получение массива со всеми данными для материала по id материала
        $dataMaterial = MaterialWithAllData::findOneMaterial($idMaterial);

        //Если данный материал не найден в базе, выводится страница с ошибкой
        if ($dataMaterial === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данная статья не существует!',
                    'description' => 'Вы ввели неправильный номер статьи.'
                ],
                404);
            exit();
        }

        //Создание объекта материала
        $material = new MaterialWithAllData(
            (int) $dataMaterial[0]['id'],
            $dataMaterial[0]['title'],
            $dataMaterial[0]['type'],
            $dataMaterial[0]['author'],
            $dataMaterial[0]['category'],
            $dataMaterial[0]['tag'],
            $dataMaterial[0]['description']
        );

        //Получение всех тегов
        $tags = Tag::findAllInObject();

        $this->view->renderHtml(
            'view-material.php',
            ['title' => 'Материалы', 'material' => $material, 'tags' => $tags]
        );
    }

    /*
     * Создание нового материала
     */
    public function create()
    {
        if (!empty($_POST)) {
            try {

               $materialId = MaterialWithAllData::createNewMaterial($_POST);
               header('Location: /material/show/' . $materialId);
               exit();

            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        //Получение всех категорий
        $allCategory = Category::findAllInObject();

        //Отображение шаблона создания и редактирования материала
        $this->view->renderHtml(
            'create-material.php',
            [
                'title' => 'Материалы',
                'categories' => $allCategory,
                'action' => 'material/create',
                'act' => 'Добавить',
                'button' => 'Добавить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    /*
     * Редактирование материала
     */

    public function edit($idMaterial)
    {
        //Получение всех категорий
        $allCategory = Category::findAllInObject();

        //Отображение шаблона создания и редактирования материала
        $this->view->renderHtml(
            'create-material.php',
            [
                'title' => 'Материалы',
                'categories' => $allCategory,
                'action' => 'material/create' . $idMaterial,
                'act' => 'Редактировать',
                'button' => 'Изменить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    /*
     * Удаление материала
     */
    public function delete($idMaterial)
    {
        //Получение массива со всеми данными для материала по id материала
        $dataMaterial = MaterialWithAllData::findOneMaterial($idMaterial);

        //Если данный материал не найден в базе, редирект на страницу с материалами
        if ($dataMaterial === null) {
            header('Location: /');
            exit();
        }

        //Удаление материала из таблицы material и связей с материалом
        MaterialWithAllData::deleteMaterial($idMaterial);

        //Редирект на страницу с материалами
        header('Location: /');
    }
}
