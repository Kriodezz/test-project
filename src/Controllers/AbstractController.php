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

    public static function returnResultsFind($arrayMaterials)
    {
        $arrayObject = [];
        if ($arrayMaterials !== null) {
            foreach ($arrayMaterials as $data) {
                $arrayObject[] = new MaterialWithAllData(
                    (int)$data['id'],
                    $data['title'],
                    $data['type'],
                    $data['author'],
                    $data['category'],
                    $data['tag'],
                    $data['description']
                );
            }
        }
        return $arrayObject;
    }

    public static function addDataForMaterials($materials, $data, $nameProperty): array
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
