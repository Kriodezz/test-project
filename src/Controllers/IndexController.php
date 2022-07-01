<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\MaterialForDisplay;

class IndexController extends AbstractController
{
    public function index()
    {
        $arrayData = MaterialForDisplay::findAllMaterial();

        $arrayObject = [];
        foreach ($arrayData as $data) {
            $arrayObject[] = new MaterialForDisplay(
                                                    (int) $data['id'],
                                                    $data['title'],
                                                    $data['type'],
                                                    $data['author'],
                                                    $data['category'],
                                                    $data['tag']
                                                    );
        }

        $this->view->renderHtml(
            'list-materials.php', ['title' => 'Материалы', 'data' => $arrayObject]
        );
    }
}
