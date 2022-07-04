<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Controllers\AbstractController;
use Tara\TestProject\Exception\InvalidArgumentException;

class MaterialWithAllData extends AbstractModel
{
    protected string $title;
    protected string $type;
    protected ?array $authors;
    protected ?array $categories;
    protected ?array $tags;
    protected ?string $description;

    /**
     * @param int $id
     * @param string $title
     * @param string $type
     * @param array|null $authors
     * @param array|null $categories
     * @param array|null $tags
     * @param string|null $description
     */
    public function __construct(
        int     $id,
        string  $title,
        string  $type,
        ?array  $authors,
        ?array   $categories,
        ?array   $tags,
        ?string $description
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->authors = $authors;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->description = $description;
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
     * @return array|null
     */
    public function getAuthors(): ?array
    {
        return $this->authors;
    }

    /**
     * @return array|null
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public static function findAllMaterial(): ?array
    {
        $materials = Material::findAll();

        if (empty($materials)) {
            return null;
        }

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

    public static function findSeveralMaterials($arrayWithId): ?array
    {
        $materials = [];
        foreach ($arrayWithId as $id) {
            $materials[] = Material::findById($id)[0];
        }

        if (empty($materials)) {
            return null;
        }

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

    public static function findOneMaterial($id): ?array
    {
        $material = Material::findById($id);

        if (empty($material)) {
            return null;
        }

        $authors = Author::getDataForMaterials([$id]);
        $categories = Category::getDataForMaterials([$id]);
        $tags = Tag::getDataForMaterials([$id]);

        $material = AbstractController::addDataForMaterials($material, $authors, 'author');
        $material = AbstractController::addDataForMaterials($material, $categories, 'category');
        return AbstractController::addDataForMaterials($material, $tags, 'tag');
    }

    public static function createNewMaterial($data): int
    {
        $exceptions = new InvalidArgumentException();

        if (($data['type'] === 'Выберите тип') ||
            !in_array(
                    $data['type'],
                    ['Книга', 'Статья', 'Видео', 'Сайт/Блог', 'Подборка', 'Ключевые идеи книги']
            )
        ) {
            $exceptions->setException('type');
        }

        $allCategories = Category::getDataColumn('title');
        if (($data['category'] === 'Выберите категорию') ||
            !in_array(
                $data['category'],
                $allCategories
            )
        ) {
            $exceptions->setException('category');
        }

        if (empty($data['title'])) {
            $exceptions->setException('title');
        }

        if (!empty($data['authors'])) {
            $AuthorsWithOneSeparator = preg_replace(
                '~\s*[\.,\,,\:,\;,\/,\|,\\\]\s*~',
                '|', $data['authors']);
            $arrayAuthors = explode('|', $AuthorsWithOneSeparator);
            $arrayObjectAuthors = [];
            foreach ($arrayAuthors as $keyAuthor => $author) {
                if (preg_match('~^[A-я,\s]+$~', $author)) {
                    $arrayObjectAuthors[$keyAuthor] = new Author();
                    $arrayObjectAuthors[$keyAuthor]->setName($author);
                } else {
                    $exceptions->setException('authors', "Недопустимые символы в имени $author");
                }
            }
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $material = new Material();
        $material->setTitle(htmlentities($data['title']));
        $material->setType($data['type']);
        if ($data['description'] !== null) {
            $material->setDescription(nl2br(htmlentities($data['description'])));
        } else {
            $material->setDescription(null);
        }
        $material->save();

        if (!empty($arrayObjectAuthors)) {
            $AllAuthors = Author::getDataColumn('title');

            foreach ($arrayObjectAuthors as $simpleObjectAuthor) {
                if (in_array($simpleObjectAuthor->getName(), $AllAuthors)) {
                    $author = Author::findByColumnStrict('title', $simpleObjectAuthor->getName());
                    Author::addPropertyToMaterial($author[0]->getId(), $material->getId());
                } else {
                    $author = new Author();
                    $author->setName($simpleObjectAuthor->getName());
                    $author->save();
                    Author::addPropertyToMaterial($author->getId(), $material->getId());
                }
            }
        }

        $category = Category::findByColumnStrict('title', $data['category']);
        $idCategory = $category[0]->getId();
        Category::addPropertyToMaterial($idCategory, $material->getId());

        return $material->getId();
    }
}
