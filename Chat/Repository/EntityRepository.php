<?php

namespace Repository;

/**
 * Class EntityRepository
 * @package Repository
 */
trait EntityRepository
{

    /**
     * {@inheritdoc}
     */
    public function findOne(array $arguments = [])
    {
        return $this->createData($this->getEntityData($arguments));
    }

    /**
     * Get entity data.
     *
     * @param array $arguments
     *
     * @return array
     */
    abstract protected function getEntityData(array $arguments = []);

}
