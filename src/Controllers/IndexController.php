<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\MaterialWithAllData;

class IndexController extends AbstractController
{
    public function index()
    {
        $arrayData = MaterialWithAllData::findAllMaterial();

        $arrayObject = [];
        foreach ($arrayData as $data) {
            $arrayObject[] = new MaterialWithAllData(
                (int) $data['id'],
                $data['title'],
                $data['type'],
                $data['author'],
                $data['category'],
                $data['tag'],
                $data['description']
            );
        }

        $this->view->renderHtml(
            'list-materials.php', ['title' => 'Материалы', 'data' => $arrayObject]
        );
    }
}
