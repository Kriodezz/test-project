<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\MaterialWithAllData;

class IndexController extends AbstractController
{
    public function index()
    {
        $allMaterials = MaterialWithAllData::findMaterials();

        $this->view->renderHtml(
            'list-materials.php', ['title' => 'Материалы', 'data' => $allMaterials]
        );
    }
}
