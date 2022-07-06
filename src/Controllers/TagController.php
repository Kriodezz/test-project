<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Models\Material;
use Tara\TestProject\Models\MaterialWithAllData;
use Tara\TestProject\Models\Tag;

class TagController extends AbstractController
{
    /*
     * Отображение списка тегов
     */
    public function show()
    {
        $allTags = Tag::findAll();

        $this->view->renderHtml(
            'list-tag.php',
            ['title' => 'Теги', 'tags' => $allTags]
        );
    }

    /*
     * Добавление тега к материалу
     */
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
                Tag::addPropertyToMaterial((int)$idTag, (int)$materialId);
                header('Location: /material/show/' . $materialId);
            } catch (\PDOException $e) {
                header('Location: /material/show/' . $materialId);
            }
        }
    }

    /*
     * Поиск и отображение списка материалов по тегу
     */
    public function findByTag($tagId)
    {
        $tag = Tag::findById($tagId);
        if ($tag === null) {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'Такого тега нет!'],
                404);
            exit();
        }

        $idMaterialsWithCurrentTag = Tag::getMaterialsByTag($tag->getId());
        if ($idMaterialsWithCurrentTag === null) {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'По данному тегу ничего не найдено'],
                404);
            exit();
        }

        $materials = MaterialWithAllData::findMaterials($idMaterialsWithCurrentTag);

        if (empty($materials)) {
            $this->view->renderHtml(
                'errors/error.php',
                ['error' => 'По данному тегу ничего не найдено'],
                404);
            exit();
        }

        $this->view->renderHtml(
            'list-materials.php',
            ['title' => 'Материалы', 'data' => $materials]
        );
    }

    /*
     * Создание нового тега
     */
    public function create()
    {
        if (!empty($_POST)) {
            try {
                Tag::createTag($_POST);
                header('Location: /tags/show');
                exit();
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        $this->view->renderHtml(
            'create-tag.php',
            [
                'title' => 'Теги',
                'action' => '/tag/create',
                'act' => 'Добавить',
                'button' => 'Добавить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    /*
     * Редактирование существующего тега
     */
    public function edit($idTag)
    {
        $tag = Tag::findById($idTag);

        if ($tag === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Такого тега нет!',
                    'description' => 'Вы ввели неправильный тег.'
                ],
                404);
            exit();
        }

        if (!empty($_POST)) {
            try {
                $tag->updateTag($_POST);
                header('Location: /tags/show');
                exit();
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }

        $this->view->renderHtml(
            'create-tag.php',
            [
                'title' => 'Теги',
                'tag' => $tag,
                'action' => '/tag/edit/' . $idTag,
                'act' => 'Редактировать',
                'button' => 'Изменить',
                'exceptions' => $dataExceptions ?? null
            ]
        );
    }

    /*
     * Удаление тега
     */
    public function delete($idTag)
    {
        $tag = Tag::findById($idTag);
        $tag->deleteRelations();
        $tag->delete();
        header('Location: /tags/show');
    }

    /*
     * Удаление тега из материала
     */
    public function deleteFromMaterial($tagId, $materialId)
    {
        $tag = Tag::findById($tagId);
        $material = Material::findById($materialId);

        if ($material === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данный материал не существует!',
                    'description' => 'Вы ввели неправильный номер материала.'
                ],
                404);
            exit();
        } elseif ($tag === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данный тег не существует!',
                    'description' => 'Вы ввели неправильный номер тега.'
                ],
                404);
            exit();
        } else {
            $tag->deleteTagFromMaterial($materialId);
            header('Location: /material/show/' . $materialId);
        }
    }
}
