<?php

namespace Tara\TestProject\Controllers;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Models\Link;
use Tara\TestProject\Models\Material;

class LinkController extends AbstractController
{
    /*
     * Создание ссылки
     */
    public function create($idMaterial)
    {
        $material = Material::findById($idMaterial);
        if ($material === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данный материал не существует!',
                    'description' => 'Вы ввели неправильный номер материала.'
                ],
                404);
            exit();
        }

        if (!empty($_POST)) {
            try {
                Link::createLink($idMaterial, $_POST);
                header('Location: /material/show/' . $idMaterial);
                exit();
            } catch (InvalidArgumentException $exception) {
                $dataExceptions = $exception->getAllException();
            }
        }
        header('Location: /material/show/' . $idMaterial);
    }

    /*
     * Редактирование ссылки
     */
    public function edit($idMaterial, $idLink)
    {var_dump($idMaterial);
        var_dump($idLink);
        var_dump($_POST);
        $material = Material::findById($idMaterial);
        if ($material === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данный материал не существует!',
                    'description' => 'Вы ввели неправильный номер материала.'
                ],
                404);
            exit();
        }

        $link = Link::findById($idLink);
        if ($link === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данная ссылка не существует!',
                    'description' => 'Вы ввели неправильный номер ссылки.'
                ],
                404);
            exit();
        }

        if ($link->getMaterialId() === (int) $idMaterial) {
            if (!empty($_POST)) {
                try {
                    $link->updateLink($_POST);
                } catch (InvalidArgumentException $exception) {
                    $dataExceptions = $exception->getAllException();
                }
            }
            header('Location: /material/show/' . $idMaterial);
        } else {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данная ссылка не относится к данному!',
                    'description' => 'Вы ввели неправильный номер ссылки или материала.'
                ],
                404);
            exit();
        }
    }

    /*
     * Удаление ссылки
     */
    public function delete($idLink, $idMaterial): void
    {
        $material = Material::findById($idMaterial);
        if ($material === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данный материал не существует!',
                    'description' => 'Вы ввели неправильный номер материала.'
                ],
                404);
            exit();
        }

        $link = Link::findById($idLink);
        if ($link === null) {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данная ссылка не существует!',
                    'description' => 'Вы ввели неправильный номер ссылки.'
                ],
                404);
            exit();
        }

        if ($link->getMaterialId() === (int) $idMaterial) {
            $link->delete();
            header('Location: /material/show/' . $idMaterial);
        } else {
            $this->view->renderHtml(
                'errors/error.php',
                [
                    'error' => 'Данная ссылка не относится к данному!',
                    'description' => 'Вы ввели неправильный номер ссылки или материала.'
                ],
                404);
            exit();
        }
    }
}
