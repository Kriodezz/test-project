<?php

namespace Tara\TestProject\Models;

class Author extends AbstractModel
{
    const TABLE_NAME = 'author';

    protected string $title;

    /**
     * @return string
     */
    public function getName(): string

    {
        return $this->title;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->title = $name;
    }
}
