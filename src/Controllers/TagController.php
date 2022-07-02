<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Models\Material;
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
}
