<?php

namespace Tara\TestProject\Controllers;

class TagController extends AbstractController
{
    public function show()
    {
        $this->view->renderHtml(
            'list-tag.php', ['title' => 'Теги']);
    }
}
