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
            $exceptions->setException('category');
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $category = new Category();
        $category->setTitle(htmlentities($data['category']));
        $category->save();
    }
}
