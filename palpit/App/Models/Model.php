<?php

namespace App\Models;

use Exception;
use App\Providers\DatabaseProvider;
use stdClass;

class Model
{
    protected static $table      = '';
    protected static $primaryKey = '';
    protected static $columns    = [];

    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get(string $index)
    {
        if (array_key_exists($index, $this->data)) {
            return $this->data[$index];
        }

        return null;
    }

    public function __set(string $index, $value)
    {
        return $this->data[$index] = $value;
    }

    public static function find($id)
    {
        $conn = DatabaseProvider::getInstance();
        $sql  = implode(" ", [
            "SELECT *",
            "FROM " . static::$table,
            "WHERE " . static::$primaryKey . " = :id",
            "LIMIT 1;"
        ]);

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);

        if ($stmt->execute() && $stmt->rowCount() == 1) {
            return new static((array) $stmt->fetchObject());
        }

        return [];
    }

    private static function mountedWhere(array $where = []): object
    {
        $result = new stdClass;

        $result->values = [];
        $result->where  = [];

        if (count($where) > 0) {
            foreach ($where as $condition) {
                if (count($condition) === 3) {
                    array_push(
                        $result->where, 
                        $condition[0] . " " . $condition[1] . " :" . $condition[0]
                    );

                    $result->values[":" . $condition[0]] = $condition[2];
                } elseif (count($condition) === 2) {
                    array_push(
                        $result->where, 
                        $condition[0] . " = :" . $condition[0]
                    );

                    $result->values[":" . $condition[0]] = $condition[1];
                } else {
                    array_push($result->where, $condition);
                }
            }
        }

        if (count($result->where) > 0) {
            $result->where = "WHERE " . implode(" AND ", $result->where);
        } else {
            $result->where = "";
        }

        return $result;
    }

    private static function mountedOption(
        int $limit = null, 
        int $offset = null, 
        array $group = null
    ): string {
        $result = [];

        if (!is_null($limit)) {
            array_push($result, "LIMIT {$limit}");
        } 
        
        if (!is_null($offset)) {
            array_push($result, "OFFSET {$limit}");
        }

        if (!is_null($group) and count($group) > 0) {
            array_push($result, implode(",", $group));
        }

        return implode(" ", $result);
    }

    public static function get(
        array $where = [], 
        int $limit = null, 
        int $offset = null, 
        array $group = null
    ) {
        $conn   = DatabaseProvider::getInstance();
        $where  = self::mountedWhere($where);
        $option = self::mountedOption($limit, $offset, $group);
        $result = [];

        $sql  = implode(" ", [
            "SELECT *",
            "FROM " . static::$table,
            $where->where,
            $option
        ]);
        
        $stmt = $conn->prepare($sql);

        if (count($where->values) > 0) {
            foreach ($where->values as $index => $value) {
                $stmt->bindValue($index, $value);
            }
        }

        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $fetchAll = $stmt->fetchAll();

            foreach ($fetchAll as $line) {
                array_push($result, new static($line));
            }
        }

        return $result;
    }

    public function toArray(): array
    {
        return $this->data;
    } 
}
