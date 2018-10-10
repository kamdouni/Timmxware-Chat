<?php

namespace Repository;


use Model\Chat;

/**
 * Class ChatRepository
 * @package Repository
 */
class ChatRepository extends AbstractRepository implements CollectionInterface, EntityInterface
{
    use CollectionRepository;
    use EntityRepository;

    /**
     * {@inheritdoc}
     */
    protected function createData(array $data)
    {
        if (empty($data)) {
            return null;
        }

        $user = new Chat($data);

        return $user;

    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityData(array $arguments = [])
    {
        $where = '';
        foreach ($arguments as $name => $value) {
            $value = mysql_real_escape_string($value);
            $where .= "$name ='$value' and ";
        }
        $where = substr($where, 0, strlen($where) - 4);

        $data = $this->getConnexion()->getFromEntity('messages', ["*"], $where, null, null, 1);
        if (count($data) == 1) {
            return $data[0];
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCollectionData(array $arguments = [])
    {
        $where = '';
        foreach ($arguments as $name => $value) {
            $value = mysql_real_escape_string($value);
            $where .= "$name ='$value' and ";
        }
        $where = substr($where, 0, strlen($where) - 4);

        $data = $this->getConnexion()->getFromEntity('messages', ["*"], $where, 'id', 'DESC', 10);

        return $data;
    }

    /**
     * @param array $arguments
     */
    public function addData(array $arguments = [])
    {

        return $this->getConnexion()->addToEntity('messages', ["sender", "message", "send_at"], $arguments);

    }
}
