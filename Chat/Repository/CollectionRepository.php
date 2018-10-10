<?php

namespace Repository;


trait CollectionRepository
{

    /**
     * {@inheritdoc}
     */
    public function find(array $arguments = [])
    {
        {
            $collectionData = $this->getCollectionData($arguments);
            if (is_array($collectionData)) {
                return array_map(
                [$this, 'createData'],
                    $collectionData
            );
            }
        }

        return [];
    }

    /**
     * Get collection data.
     *
     * @param array $arguments
     *
     * @return array
     */
    abstract protected function getCollectionData(array $arguments = []);


}
