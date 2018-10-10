<?php

namespace Repository;

interface CollectionInterface extends RepositoryInterface
{
    /**
     * Find entities.
     *
     * @param array $arguments
     *
     * @return array
     */
    public function find(array $arguments = []);
}
