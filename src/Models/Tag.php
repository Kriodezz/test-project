<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Services\Db;

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

    public function deleteTagFromMaterial($idMaterial): void
    {
        $db = Db::getInstance();
        $db->execute(
            'DELETE FROM material_tag 
            WHERE material_id = :material_id AND tag_id = :tag_id',
            [':material_id' => $idMaterial, ':tag_id' => $this->getId()]
        );
    }

    public static function getMaterialsByTag($idTag): ?array
    {
        $db = Db::getInstance();
        $results = $db->queryArray(
            'SELECT material_id FROM material_tag 
                WHERE tag_id = :id',
            [':id' => $idTag]
        );
        if (empty($results)) {
            return null;
        }
        $data = [];
        foreach ($results as $result) {
           $data[] = $result['material_id'];
        }
        return $data;
    }

    public static function createTag($data): void
    {
        $exceptions = new InvalidArgumentException();

        if (empty($data['tag'])) {
            $exceptions->setException('tag', 'Имя тега не должно быть пустым');
        }

        $allTags = Tag::getDataColumn('title');
        if (in_array($data['tag'], $allTags)) {
            $exceptions->setException('tag', 'Такой тег уже существует');
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $tag = new Tag();
        $tag->setTitle(htmlentities($data['tag']));
        $tag->save();
    }

    public function updateTag($data)
    {
        $exceptions = new InvalidArgumentException();

        if (empty($data['tag'])) {
            $exceptions->setException('tag');
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $this->setTitle(htmlentities($data['tag']));
        $this->save();
    }
}
