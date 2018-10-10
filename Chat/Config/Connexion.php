<?php
namespace Config;

use PDO;

/**
 * Class Connexion
 * @package Config
 */
class Connexion
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'chat';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host; dbname=$dbname",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
            $this->pdo->exec('SET CHARACTER SET utf8');
        } catch (Exception $e) {
            die('ERREUR : Impossible de se connecter à la base de donnée.' . $e->getMessage());
        }
    }

    /**
     * @param $entity
     * @param $parameters
     * @param $orderBy
     * @param $order
     * @param $limit
     * @return array
     */
    public function getFromEntity($entity, $parameters, $where, $orderBy, $order, $limit)
    {
        $sql = 'SELECT ';
        $sql .= implode(',', $parameters);
        $sql .= ' FROM ' . $entity;

        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy . ' ' . $order;
        }
        if ($limit) {
            $sql .= ' LIMIT ' . $limit;
        }


        $query = $this->pdo->query($sql);
        $result = [];

        while ($data = $query->fetch()) {
            $result[] = $data;
        }

        return $result;
    }

    /**
     * @param $entity
     * @param $parameters
     * @param $values
     */
    public function addToEntity($entity, $parameters, $values)
    {
        $sql = 'INSERT INTO ' . $entity . '(' . implode(', ', $parameters) . ') ';
        $sql .= ' VALUES (' . implode(', ', $values).')';
        $query = $this->pdo->prepare($sql);
        $query->execute();
    }

    /**
     * @param $entity
     * @param $parameters
     * @param $values
     * @param $where
     */
    public function editEntity($entity, $parameters, $values, $where)
    {
        $sql = 'UPDATE ' . $entity;
        $sql .= ' SET ' . implode(', ', $parameters) . ' = ' . $values;
        $sql .= ' WHERE ' . $where;
        $query = $this->pdo->prepare($sql);
        $query->execute();
    }
}