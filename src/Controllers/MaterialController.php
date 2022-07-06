<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Models\Author;
use Tara\TestProject\Models\Category;
use Tara\TestProject\Models\Material;
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
            $idNecessaryMaterials = [];

            $materials = Material::findSomeByColumn(
                'title',
                htmlentities($_POST['data-from-user'])
            );
            if ($materials !== null) {
                foreach ($materials as $material) {
                    $idNecessaryMaterials[] = $material->getId();
                }
            }

            $authors = Author::findSomeByColumn(
                'title',
                htmlentities($_POST['data-from-user'])
            );
            if ($authors !== null) {
                foreach ($authors as $author) {
                    $idMaterialsCurrentAuthor = Author::findByColumn(
                        'author_id',
                        $author->getId(),
                        'multiple',
                        'material_author'
                    );
                    foreach ($idMaterialsCurrentAuthor as $idAuthor) {
                        $idNecessaryMaterials[] = $idAuthor->material_id;
                    }
                }
            }

            $tags = Tag::findSomeByColumn(
                'title',
                htmlentities($_POST['data-from-user'])
                );
            if ($tags !== null) {
                foreach ($tags as $tag) {
                    $idMaterialsCurrentTag = Tag::findByColumn(
                        'tag_id',
                        $tag->getId(),
                        'multiple',
                        'material_tag'
                    );
                    foreach ($idMaterialsCurrentTag as $idTag) {
                        $idNecessaryMaterials[] = $idTag->material_id;
                    }
                }
            }

            $categories = Category::findSomeByColumn(
                'title',
                htmlentities($_POST['data-from-user'])
            );
            if ($categories !== null) {
                foreach ($categories as $category) {
                    $idMaterialsCurrentCategory = Category::findByColumn(
                        'category_id',
                        $category->getId(),
                        'multiple',
                        'material_category'
                    );
                    foreach ($idMaterialsCurrentCategory as $idCategory) {
                        $idNecessaryMaterials[] = $idCategory->material_id;
                    }
                }
            }

            if (!empty($idNecessaryMaterials)) {
                $uniqueId = array_unique($idNecessaryMaterials);
                $data = MaterialWithAllData::findMaterials($uniqueId);
                if (empty($data)) {
                    $this->view->renderHtml(
                        'list-materials.php',
                        ['title' => 'Материалы']
                    );
                } else {
                    $this->view->renderHtml(
                        'list-materials.php',
                        ['title' => 'Материалы', 'data' => $data]
                    );
                }
            }

            $this->view->renderHtml(
                'list-materials.php',
                ['title' => 'Материалы']
            );
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
        $material = MaterialWithAllData::findOneMaterial($idMaterial);

        //Если данный материал не найден в базе, выводится страница с ошибкой
        if ($material === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данная статья не существует!',
                    'description' => 'Вы ввели неправильный номер статьи.'
                ],
                404);
            exit();
        }

        //Получение всех тегов
        $tags = Tag::findAll();

        $this->view->renderHtml(
            'view-material.php',
            [
                'title' => 'Материалы',
                'material' => $material,
                'tags' => $tags
            ]
        );
    }

    /*
     * Создание нового материала
     */
    public function create()
    {
        if (!empty($_POST)) {
            try {
                //Создаем записи в БД, получаем id созданного материала
                $materialId = MaterialWithAllData::createNewMaterial($_POST);

                //Редирект на страницу просмотра с новым материалом
                header('Location: /material/show/' . $materialId);
                exit();

            /*
             * При неуспешной валидации сведения об ошибках записываются
             * в $dataExceptions и передаются в шаблон
             */
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        //Получение всех категорий для отображения в шаблоне
        $allCategory = Category::findAll();

        //Отображение шаблона создания и редактирования материала
        $this->view->renderHtml(
            'create-material.php',
            [
                'title' => 'Материалы',
                'AllCategories' => $allCategory,
                'action' => '/material/create',
                'act' => 'Добавить',
                'button' => 'Добавить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    /*
     * Редактирование материала
     */
    public function edit($idMaterial, $whereWereBefore)
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

        if (!empty($_POST)) {
            try {
                $dataMaterial->updateMaterial($_POST);
                if ($whereWereBefore === 'index') {
                    header('Location: /');
                }  else {
                    header('Location: /' . $whereWereBefore);
                }
                exit();
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        //Получение всех категорий для отображения в шаблоне
        $allCategories = Category::findAll();

        //Отображение шаблона создания и редактирования материала
        $this->view->renderHtml(
            'create-material.php',
            [
                'title' => 'Материалы',
                'material' => $dataMaterial,
                'AllCategories' => $allCategories,
                'action' => '/material/edit/' . $idMaterial,
                'act' => 'Редактировать',
                'button' => 'Изменить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    /*
     * Удаление материала
     */
    public function delete($idMaterial, $whereWereBefore)
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

        //Редирект на ту страницу просмотра материалов, из которой произошло удаление

        if ($whereWereBefore === 'index') {
            header('Location: /');
        }  else {
            header('Location: /' . $whereWereBefore);
        }
    }
}
