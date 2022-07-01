<?php

namespace Tara\TestProject\Models;

class Tag extends AbstractModel
{
    const TABLE_NAME = 'tag';

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
