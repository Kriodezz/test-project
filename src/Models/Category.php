<?php

namespace Tara\TestProject\Models;

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
}
