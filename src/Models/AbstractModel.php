<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Services\Db;

abstract class AbstractModel
{
    protected int $id;

    /**
     * @return int
     */
    public function getId(): int
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

    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->queryArray('SELECT * FROM ' . static::TABLE_NAME);
    }

    public static function findById($id): array
    {
        $db = Db::getInstance();
        return $db->queryArray(
            'SELECT * FROM ' . static::TABLE_NAME . ' WHERE id = :id',
            [':id' => $id]
        );
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
}
