<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\MaterialForDisplay;
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
        $dataMaterial = MaterialForDisplay::findOneMaterial($id);

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

        $material = new MaterialForDisplay(
            (int) $dataMaterial[0]['id'],
            $dataMaterial[0]['title'],
            $dataMaterial[0]['type'],
            $dataMaterial[0]['author'],
            $dataMaterial[0]['category'],
            $dataMaterial[0]['tag'],
            $dataMaterial[0]['description']
        );

        $tags = Tag::findAll();

        $this->view->renderHtml(
            'view-material.php',
            ['title' => 'Материалы', 'material' => $material, 'tags' => $tags]
        );
    }

    public function create()
    {
        $this->view->renderHtml(
            'create-material.php', ['title' => 'Материалы']);
    }
}
