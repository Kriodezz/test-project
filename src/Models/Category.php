<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Exception\InvalidArgumentException;

class Category extends AbstractModel
{
    const TABLE_NAME = 'category';

    protected string $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public static function createCategory($data): void
    {
        $exceptions = new InvalidArgumentException();

        if (empty($data['category'])) {
            $exceptions->setException('category', 'Название не должно быть пустым');
        }

        $allCategory = Category::getDataColumn('title');
        if (in_array($data['category'], $allCategory)) {
            $exceptions->setException('category', 'Такая категория уже существует');
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $category = new Category();
        $category->setTitle(htmlentities($data['category']));
        $category->save();
    }

    public function updateCategory($data)
    {
        $exceptions = new InvalidArgumentException();

        if (empty($data['category'])) {
            $exceptions->setException('category');
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $this->setTitle(htmlentities($data['category']));
        $this->save();
    }
}
