<?php
class Orm
{
    protected $id;
    protected $table;
    protected $db;
    function __construct($id, $table, PDO $conn)
    {
        $this->id = $id;
        $this->table = $table;
        $this->db = $conn;
    }

    function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll();
    }

    function getByID($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->fetch();
    }

    function deleteByID($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        if ($stm->rowCount() > 0)
            $success = true;
        return $success;
    }

    function updateByID($id, $data)
    {
        $sql = "UPDATE {$this->table} SET ";
        $params = [];
        foreach ($data as $key => $value) {
            $sql .= "{$key} = :{$key}, ";
            $params[":{$key}"] = $value;
        }

        $sql = rtrim($sql, ', ');
        $sql .= " WHERE id = :id";
        $params[':id'] = $id;

        $stm = $this->db->prepare($sql);

        $success = false;
        try {
            $success = $stm->execute($params);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $success;
    }

    function insert($data)
    {
        $sql = "INSERT INTO {$this->table}(";
        $values = "(";
        foreach ($data as $key => $value) {
            $sql .= "{$key}, ";
            $values .= ":{$key}, ";
        }

        $sql = rtrim($sql, ', ') . ') VALUES ' . rtrim($values, ', ') . ')';
        $stm = $this->db->prepare($sql);

        $success = false;
        try {
            $success = $stm->execute($data);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $success;
    }

}
?>