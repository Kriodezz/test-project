<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Services\Db;

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

    public static function existAuthor($authors, $materialId): void
    {
        $allAuthors = Author::getDataColumn('title');
        foreach ($authors as $nameAuthor) {
            if (in_array($nameAuthor, $allAuthors)) {
                $author = Author::findByColumn('title', $nameAuthor, 'simple');
            } else {
                $author = new Author();
                $author->setName($nameAuthor);
                $author->save();
            }
            Author::addPropertyToMaterial($author->getId(), $materialId);
        }
    }
}
