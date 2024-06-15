<?php
class Usuarios extends Orm
{
    function __construct(PDO $connection)
    {
        parent::__construct('id', 'Usuarios', $connection);
    }
    function validaLogin($data)
    {
        $sql = "SELECT * FROM {$this->table} WHERE " . $data;
        $stm = $this->db->prepare($sql);
        try {
            $stm->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $stm->fetch();
    }
}
?>