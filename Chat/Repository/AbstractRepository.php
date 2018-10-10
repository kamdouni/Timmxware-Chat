<?php

namespace Repository;

use Config\Connexion;

abstract class AbstractRepository
{
    /**
     * @var Connexion
     */
    private $connexion;

    public function __construct(Connexion $connexion)
    {
        $this->connexion = $connexion;
    }

    /**
     * @return Connexion
     */
    protected function getConnexion()
    {
        return $this->connexion;
    }

    /**
     * Create data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function createData(array $data)
    {
        return $data;
    }

}
