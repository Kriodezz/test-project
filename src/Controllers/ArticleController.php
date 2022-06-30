<?php

namespace Tara\TestProject\Controllers;

class ArticleController extends AbstractController
{
    public function create()
    {
        $this->view->renderHtml(
            'create-material.php', ['title' => 'Материалы']);
    }
}
