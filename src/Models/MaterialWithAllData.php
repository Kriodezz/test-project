<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Services\Db;
use Tara\TestProject\Services\Validation;

class MaterialWithAllData extends AbstractModel
{
    protected string $title;
    protected string $type;
    protected array $authors;
    protected string $category;
    protected array $tags;
    protected ?string $description;

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
     * @return array
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param array $authors
     */
    public function setAuthors(array $authors): void
    {
        $this->authors = $authors;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /*
     * Получение объектов нескольких материалов
     */
    public static function findMaterials($arrayWithId = []): array
    {
        //Получение данных для списка материалов из таблицы material
        if (empty($arrayWithId)) {
            $materials = Material::findAll();
            foreach ($materials as $item) {
                $arrayWithId[] = $item->getId();
            }
        } else {
            $materials = [];
            foreach ($arrayWithId as $id) {
                $materials[] = Material::findById($id);
            }
        }

        if (empty($materials)) {
            return $materials;
        }

        //Получение данных об авторах и категориях для списка материалов
        $authorsForMaterials = Author::getDataForMaterials($arrayWithId);
        $categoryForMaterials = Category::getDataForMaterials($arrayWithId, 'simple');

        //Создание объектов материалов со всеми данными
        $materialsWithAllData = [];
        foreach ($materials as $keyMaterial => $material) {
            if ($material === null) {
                continue;
            }
            $materialWithAllData = new MaterialWithAllData();
            $materialWithAllData->setId($material->getId());
            $materialWithAllData->setTitle($material->getTitle());
            $materialWithAllData->setType($material->getType());
            $materialWithAllData->setDescription($material->getDescription());
            $materialWithAllData->setAuthors($authorsForMaterials[$keyMaterial]);
            $materialWithAllData->setCategory($categoryForMaterials[$keyMaterial]->getTitle());
            $materialsWithAllData[] = $materialWithAllData;
        }

        return $materialsWithAllData;
    }

    /*
     * Получение объекта одного материала
     */
    public static function findOneMaterial($id): ?self
    {
        //Получение данных для материала из таблицы material
        $material = Material::findById($id);

        //Если материал не найден возвращает null
        if ($material === null) {
            return null;
        }

        //Получение данных об авторах, категориях, тегах для материала
        $authors = Author::getDataForMaterials([$id])[0];
        $category = Category::getDataForMaterials([$id], 'simple')[0];
        $tags = Tag::getDataForMaterials([$id])[0];

        //Создание объекта материала со всеми данными
        $materialWithAllData = new MaterialWithAllData();
        $materialWithAllData->setId($material->getId());
        $materialWithAllData->setTitle($material->getTitle());
        $materialWithAllData->setType($material->getType());
        $materialWithAllData->setDescription($material->getDescription());
        $materialWithAllData->setAuthors($authors);
        $materialWithAllData->setCategory($category->getTitle());
        $materialWithAllData->setTags($tags);

        return $materialWithAllData;
    }

    /*
     * Создание нового материала и возвращение его id
     */
    public static function createNewMaterial($data): int
    {
        /*
         * Валидация полученных данных
         */
        $authors = Validation::validationDataMaterial($data);

        /*
         * Если валидация пройдена создаем объект материала с данными для записи
         * в таблицу material и сохраняем данные в таблицу
         */
        $material = Material::createMaterial($data);

        /*
         * Если были переданы данные об авторах проверяем их наличие в таблице author
         * и добавляем связь с создаваемым материалом.
         * Если автора в БД нет - он заносится в БД
         */
        if (!empty($authors)) {
            Author::existAuthor($authors, $material->getId());
        }

        //Добавление категории к материалу
        Category::addPropertyToMaterial($data['category'], $material->getId());

        //Возвращение id создаваемого материала
        return $material->getId();
    }

    /*
     * Изменение существующего материала
     */
    public function updateMaterial($data)
    {
        /*
        * Валидация полученных данных
        */
        $authors = Validation::validationDataMaterial($data);

        /*
         * Если валидация пройдена создаем объект материала с данными для записи
         * в таблицу material и сохраняем данные в таблицу
         */
        $material = Material::createMaterial($data, $this->getId());

        /*
         * Удаляем авторов материала. В случае передачи пользователем пустой строки
         * материал становится без авторов.
         * Если были переданы данные об авторах проверяем их наличие в таблице author
         * и добавляем связь с создаваемым материалом.
         * Если какого-либо из указанных автора в БД нет - он заносится в БД
         */
        Author::deleteFromMaterial($material->getId());
        if (!empty($authors)) {
            Author::existAuthor($authors, $material->getId());
        }

        /* Удаление старой категории из материала.
         * Добавление новой категории к материалу
         */
        Category::deleteFromMaterial($material->getId());
        Category::addPropertyToMaterial($data['category'], $material->getId());
    }

    //Удаление материала
    public static function deleteMaterial($idMaterial): void
    {
        //Подключение к БД
        $db = Db::getInstance();

        //Удаление из таблицы material
        $db->execute(
            'DELETE FROM material WHERE id = :id',
            [':id' => $idMaterial]
        );

        //Удаление связей
        Author::deleteFromMaterial($idMaterial);
        Category::deleteFromMaterial($idMaterial);
        Tag::deleteFromMaterial($idMaterial);
    }
}
