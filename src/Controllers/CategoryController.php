<?php

namespace Tara\TestProject\Controllers;

class CategoryController extends AbstractController
{
    public function show()
    {
        $this->view->renderHtml(
            'list-category.php', ['title' => 'Категории']);
    }
}
