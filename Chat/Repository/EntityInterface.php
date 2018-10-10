<?php

namespace Repository;

interface EntityInterface extends RepositoryInterface
{
    /**
     * Find entities.
     *
     * @param array $arguments
     *
     * @return array
     */
    public function findOne(array $arguments = []);
}
