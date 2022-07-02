<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\Material;
use Tara\TestProject\Models\MaterialWithAllData;
use Tara\TestProject\Models\Tag;

class TagController extends AbstractController
{
    public function show()
    {
        $allTags = Tag::findAllInObject();

        $this->view->renderHtml(
            'list-tag.php',
            ['title' => 'Теги', 'tags' => $allTags]
        );
    }

    public function addTo($materialId)
    {
        $material = Material::findById($materialId);

        if ($material === null) {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'Данная статья не найдена или удалена'],
                404);
            exit();
        }

        $idTag = $_POST['tag'] ?? null;
        if (preg_match('/\d+/', $idTag)) {
            $tag = Tag::findById($idTag);
        } else {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'Неверно введенные данные'],
                400);
            exit();
        }

        if ($tag === null) {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'Данный тег не найден или удалён'],
                404);
            exit();
        } else {
            try {
                Tag::addPropertyToMaterial((int) $idTag, (int) $materialId);
                header('Location: /material/show/' . $materialId);
            } catch (\PDOException $e) {
                header('Location: /material/show/' . $materialId);
            }
        }
    }

    public function findByTag($tag)
    {
        $currentTag = Tag::findByColumnStrict('title', $tag);
        if ($currentTag === null) {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'Такого тега нет!'],
                404);
            exit();
        }
        $idMaterialsWithCurrentTag = Tag::getMaterialsByTag($currentTag[0]->getId());
        if ($idMaterialsWithCurrentTag === null) {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'По данному тегу ничего не найдено'],
                404);
            exit();
        }
        $materials = MaterialWithAllData::findSeveralMaterials($idMaterialsWithCurrentTag);
        $arrayObject = self::returnResultsFind($materials);

        $this->view->renderHtml(
            'list-materials.php',
            ['title' => 'Материалы', 'data' => $arrayObject]
        );
    }

    public function delete($tagName, $materialId)
    {
        $tag = Tag::findByColumnStrict('title',$tagName)[0];
        $tag->deleteTagFromMaterial($materialId);
        header('Location: /material/show/' . $materialId);
    }
}
