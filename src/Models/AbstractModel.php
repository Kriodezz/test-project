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

    public static function findByColumn(string $columnName, $value): ?array
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

    public static function findByColumnStrict(string $columnName, $value): ?array
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . static::TABLE_NAME .
            ' WHERE ' . $columnName . ' = :value',
            [':value' => $value],
            static::class
        );
        return $result ?: null;
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->queryArray('SELECT * FROM ' . static::TABLE_NAME);
    }

    public static function findAllInObject(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::TABLE_NAME, [], static::class);
    }

    public static function findById($id): ?array
    {
        $db = Db::getInstance();
        return$db->queryArray(
            'SELECT * FROM ' . static::TABLE_NAME . ' WHERE id = :id',
            [':id' => $id]
        );
    }

    public static function findByIdInObject($id): ?static
    {
        $db = Db::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::TABLE_NAME . ' WHERE id = :id',
            [':id' => $id],
            static::class);

        return $data ? $data[0] : null;
    }

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

    public static function getDataForMaterials(array $idData): array
    {
        $db = Db::getInstance();

        $data = [];
        foreach ($idData as $id) {
            $sql = 'SELECT ' . static::TABLE_NAME . '.title AS ' . static::TABLE_NAME .
                   ' FROM ' . static::TABLE_NAME .
                   ' INNER JOIN material_' . static::TABLE_NAME .
                   ' ON material_' . static::TABLE_NAME . '.' . static::TABLE_NAME .
                   '_id = ' . static::TABLE_NAME . '.id
                    INNER JOIN material
                    ON material_' . static::TABLE_NAME . '.material_id = material.id
                    WHERE material.id = :id';
            $data[] = $db->queryArray(
                $sql,
                [':id' => $id]
            );
        }
        return $data;
    }

    public static function addPropertyToMaterial(int $idProperty, int $idMaterial): void
    {
        $db = Db::getInstance();
        $sql = 'INSERT INTO material_' . static::TABLE_NAME .
            ' (material_id, ' . static::TABLE_NAME . '_id) 
               VALUE (:idMaterial, :idProperty)';
        $db->execute($sql, [':idMaterial' => $idMaterial, ':idProperty' => $idProperty]);
    }

    public function save(): void
    {
        $property = $this->getProperty();

        if ($this->id !== null) {
echo '111';
        } else {
            $this->insert($property);
        }
    }

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
        $objFromDb = static::findByIdInObject($this->id);

        foreach ($objFromDb as $key => $value) {
            $this->$key = $value;
        }
    }
}
