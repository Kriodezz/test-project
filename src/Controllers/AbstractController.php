<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\View\View;

abstract class AbstractController
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Public/templates');
    }

    public static function addDataForMaterials($materials, $data, $nameProperty)
    {
        foreach ($materials as $keyMaterial => $valueMaterial) {
            foreach ($data as $keyData => $item) {
                if ($keyMaterial === $keyData) {
                    if (empty($item)) {
                        $materials[$keyMaterial][$nameProperty] = null;
                    } else {
                        foreach ($item as $valueItem) {
                            $materials[$keyMaterial][$nameProperty][] = $valueItem[$nameProperty];
                        }
                    }
                }
            }
        }
        return $materials;
    }
}
