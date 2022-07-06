<?php

namespace Tara\TestProject\Models;

class Material extends AbstractModel
{
    const TABLE_NAME = 'material';

    protected string $title;
    protected string $type;
    protected ?string $description;

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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /*
     * Создание объекта материала и заполнение свойств полученными от
     * пользователя данными, при создании и редактировании материала
     */
    public static function createMaterial($data, $id = null): self
    {
        $material = new Material();
        $material->setId($id);
        $material->setTitle(htmlentities($data['title']));
        $material->setType($data['type']);
        if ($data['description'] !== null) {
            $material->setDescription(nl2br(htmlentities($data['description'])));
        } else {
            $material->setDescription(null);
        }
        $material->save();

        return $material;
    }
}
