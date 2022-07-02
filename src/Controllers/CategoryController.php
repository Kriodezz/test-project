<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\Category;

class CategoryController extends AbstractController
{
    public function show()
    {
        $allCategory = Category::findAllInObject();

        $this->view->renderHtml(
            'list-category.php',
            ['title' => 'Категории', 'categories' => $allCategory]);
    }
}
