<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Models\Category;
use Tara\TestProject\Models\Material;
use Tara\TestProject\Models\MaterialWithAllData;
use Tara\TestProject\Models\Tag;

class MaterialController extends AbstractController
{
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

    public function show($id)
    {
        $dataMaterial = MaterialWithAllData::findOneMaterial($id);

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

        $material = new MaterialWithAllData(
            (int) $dataMaterial[0]['id'],
            $dataMaterial[0]['title'],
            $dataMaterial[0]['type'],
            $dataMaterial[0]['author'],
            $dataMaterial[0]['category'],
            $dataMaterial[0]['tag'],
            $dataMaterial[0]['description']
        );

        $tags = Tag::findAllInObject();

        $this->view->renderHtml(
            'view-material.php',
            ['title' => 'Материалы', 'material' => $material, 'tags' => $tags]
        );
    }

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

        $allCategory = Category::findAllInObject();
        $this->view->renderHtml(
            'create-material.php',
            [
                'title' => 'Материалы',
                'categories' => $allCategory,
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }
}
