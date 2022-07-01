<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Controllers\AbstractController;
use Tara\TestProject\Services\Db;

class MaterialForDisplay extends AbstractModel
{
    const TABLE_NAME = 'material';

    protected string $title;
    protected string $type;
    protected ?array $authors;
    protected array $categories;
    protected array $tags;

    /**
     * @param int $id
     * @param string $title
     * @param string $type
     * @param ?array $authors
     * @param array $categories
     * @param array $tags
     */
    public function __construct(
                                int $id,
                                string $title,
                                string $type,
                                ?array $authors,
                                array $categories,
                                array $tags
                                )
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->authors = $authors;
        $this->categories = $categories;
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return ?array
     */
    public function getAuthors(): ?array
    {
        return $this->authors;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public static function findAllMaterial(): array
    {
        $materials = Material::findAll();

        $idData = [];
        foreach ($materials as $material) {
            $idData[] = $material['id'];
        }

        $authors = Author::getDataForMaterials($idData);
        $categories = Category::getDataForMaterials($idData);
        $tags = Tag::getDataForMaterials($idData);

        $materials = AbstractController::addDataForMaterials($materials, $authors, 'author');
        $materials = AbstractController::addDataForMaterials($materials, $categories, 'category');
        return AbstractController::addDataForMaterials($materials, $tags, 'tag');
    }
}
