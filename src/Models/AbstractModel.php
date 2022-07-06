<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Services\Db;

abstract class AbstractModel
{
    protected ?int $id = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /*
     * Поиск в поле таблицы по регулярному выражению
     */
    public static function findSomeByColumn(string $columnName, $value): ?array
    {
        $value = "%$value%";
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . static::TABLE_NAME .
            ' WHERE ' . $columnName . ' LIKE ?;',
            [$value],
            static::class
        );
        return $result ?: null;
    }

    /*
     * Поиск в поле таблицы по значению
     */
    public static function findByColumn(string $columnName, $value): ?static
    {
        $db = Db::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::TABLE_NAME .
            ' WHERE ' . $columnName . ' = :value',
            [':value' => $value],
            static::class
        );
        return $data ? $data[0] : null;
    }

    /*
     * Получение всех данных в таблице
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE_NAME,
            [],
            static::class
        );
    }

    /*
     * Получение одной записи в таблице по id
     */
    public static function findById($id): ?static
    {
        $db = Db::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::TABLE_NAME . ' WHERE id = :id',
            [':id' => $id],
            static::class);

        return $data ? $data[0] : null;
    }

    /*
     * Получение всех записей в одном поле
     */
    public static function getDataColumn($column): ?array
    {
        $db = Db::getInstance();
        $data = $db->queryArray('SELECT ' . $column . ' FROM ' . static::TABLE_NAME);
        $array = [];
        foreach ($data as $value) {
            $array[] = $value[$column];
        }
        return $array;
    }

    /*
     * Получение данных об авторах, категории и тегах для материалов
     * параметром $count указывается, сколько значений может иметь объект материала:
     * одно или несколько
     * (Например: Материал может иметь несколько авторов, а категорию - одну)
     */
    public static function getDataForMaterials(array $idData, $count = 'multiple'): array|static
    {
        $db = Db::getInstance();

        $data = [];
        foreach ($idData as $id) {
            $sql = 'SELECT ' . static::TABLE_NAME . '.* 
                   FROM ' . static::TABLE_NAME .
                ' INNER JOIN material_' . static::TABLE_NAME .
                ' ON material_' . static::TABLE_NAME . '.' . static::TABLE_NAME .
                '_id = ' . static::TABLE_NAME . '.id
                    INNER JOIN material
                    ON material_' . static::TABLE_NAME . '.material_id = material.id
                    WHERE material.id = :id';
            $result = $db->query(
                $sql,
                [':id' => $id],
                static::class
            );

            if ($count === 'multiple') {
                $data[] = $result;
            } elseif ($count === 'simple') {
                $data[] = $result[0];
            }
        }
        return $data;
    }

    /*
     * Сохранение в БД
     * При редактировании имеющегося материала объект содержит id,
     * при создании нового - нет.
     */
    public function save(): void
    {
        $property = $this->getProperty();

        if ($this->id !== null) {
            $this->update($property);
        } else {
            $this->insert($property);
        }
    }

    /*
     * Добавление нового материала
     */
    public function insert($data): void
    {
        $dataWithoutNull = array_filter($data);
        $params = [];
        $columns = [];
        $paramsToValues = [];

        foreach ($dataWithoutNull as $column => $value) {
            $params[] = ':' . $column;
            $columns[] = $column;
            $paramsToValues[':' . $column] = $value;
        }

        $sql = 'INSERT INTO ' . static::TABLE_NAME .
            '(' . implode(', ', $columns) . ') 
               VALUES (' . implode(', ', $params) . ')';
        $db = Db::getInstance();
        $db->execute($sql, $paramsToValues);

        $this->id = $db->getLastInsertId();
        $this->refresh();
    }

    /*
     * Обновление существующего материала
     */
    public function update($data): void
    {
        $columnsToParams = [];
        $paramsToValues = [];
        $index = 1;
        foreach ($data as $column => $value) {
            if ($column === 'id') {
                continue;
            }
            $param = ':param' . $index; // :param1
            $columnsToParams[] = $column . ' = ' . $param; // column1 = :param1
            $paramsToValues[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::TABLE_NAME .
            ' SET ' . implode(', ', $columnsToParams) .
            ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->execute($sql, $paramsToValues);
    }

    /*
     * Удаление материала
     */
    public function delete(): void
    {
        $db = Db::getInstance();
        $db->execute(
            'DELETE FROM ' . static::TABLE_NAME . ' WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    /*
     * Удаление одной связи из материала
     */
    public function deleteRelations(): void
    {
        $db = Db::getInstance();
        $db->execute(
            'DELETE FROM material_' . static::TABLE_NAME .
            ' WHERE ' . static::TABLE_NAME . '_id = :id',
            [':id' => $this->id]
        );
    }

    /*
     * Удаление всех связей из материала
     */
    public static function deleteFromMaterial($idMaterial)
    {
        $db = Db::getInstance();
        $db->execute(
            'DELETE FROM material_' . static::TABLE_NAME . ' WHERE material_id = :id',
            [':id' => $idMaterial]
        );
    }

    /*
     * Добавление данных в таблицы связей
     */
    public static function addPropertyToMaterial(int $idProperty, int $idMaterial): void
    {
        $db = Db::getInstance();
        $sql = 'INSERT INTO material_' . static::TABLE_NAME .
            ' (material_id, ' . static::TABLE_NAME . '_id) 
               VALUE (:idMaterial, :idProperty)';
        $db->execute($sql, [':idMaterial' => $idMaterial, ':idProperty' => $idProperty]);
    }

    /*
     * Получение свойств объекта
     */
    protected function getProperty(): array
    {
        $propertiesOfObject = [];
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertiesOfObject[$propertyName] = $this->$propertyName;
        }
        return $propertiesOfObject;
    }

    protected function refresh(): void
    {
        $objFromDb = static::findById($this->id);

        foreach ($objFromDb as $key => $value) {
            $this->$key = $value;
        }
    }
}
