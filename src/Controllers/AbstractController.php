<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\MaterialWithAllData;
use Tara\TestProject\View\View;

abstract class AbstractController
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Public/templates');
    }
}
