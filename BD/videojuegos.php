<?php
class Videojuegos extends Orm
{
    function __construct(PDO $connection)
    {
        parent::__construct('id', 'Videojuegos', $connection);
    }
}
?>