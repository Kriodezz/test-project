<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\Author;
use Tara\TestProject\Models\Category;
use Tara\TestProject\Models\Material;
use Tara\TestProject\Models\MaterialForDisplay;
use Tara\TestProject\Models\Tag;

class MaterialController extends AbstractController
{
    public function create()
    {
        $this->view->renderHtml(
            'create-material.php', ['title' => 'Материалы']);
    }

    public function find()
    {
        if (!empty($_POST['data-from-user'])) {
// ------------------------------- find
        } else {
            header('Location: /');
        }
    }
}
