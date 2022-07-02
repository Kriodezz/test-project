<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\MaterialWithAllData;

class IndexController extends AbstractController
{
    public function index($arrayData = [])
    {
        $arrayData = MaterialWithAllData::findAllMaterial();

        $arrayObject = self::returnResultsFind($arrayData);

        $this->view->renderHtml(
            'list-materials.php', ['title' => 'Материалы', 'data' => $arrayObject]
        );
    }
}
