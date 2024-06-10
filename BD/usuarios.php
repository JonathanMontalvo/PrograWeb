<?php
class Usuarios extends Orm
{
    function __construct(PDO $connection)
    {
        parent::__construct('id', 'Usuarios', $connection);
    }
}
?>