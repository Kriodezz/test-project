<?php

namespace Tara\TestProject\Controllers;

class IndexController extends AbstractController
{
    public function index()
    {
        $this->view->renderHtml(
            'list-materials.php', ['title' => 'Материалы']
        );
    }
}
