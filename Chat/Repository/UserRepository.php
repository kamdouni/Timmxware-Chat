<?php

namespace Repository;


use Model\User;

/**
 * Class UserRepository
 * @package Repository
 */
class UserRepository extends AbstractRepository implements CollectionInterface, EntityInterface
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

        $user = new User($data);

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

        $data = $this->getConnexion()->getFromEntity('user', ["*"], $where, null, null, 1);
        if(count($data) == 1){
            return $data[0];
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCollectionData(array $arguments = [])
    {
        $where = $this->setWhere($arguments);

        $data = $this->getConnexion()->getFromEntity('user', ["*"], $where, null, null, null);
        return $data;
    }

    public function setStatus($pseudo, $satus)
    {
        $where = " pseudo = '$pseudo'";

        return $this->getConnexion()->editEntity('user', ["is_connected"], $satus, $where);
    }

    /**
     * @param $arguments
     * @return string
     */
    protected function setWhere($arguments)
    {
        $where = '';
        foreach ($arguments as $name => $value) {
            $value = mysql_real_escape_string($value);
            $where .= "$name ='$value' and ";
        }
        $where = substr($where, 0, strlen($where) - 4);

        return $where;
    }

    /**
     * @param array $arguments
     */
    public function addUser(array $arguments = [])
    {

        return $this->getConnexion()->addToEntity('user', ["pseudo","password","is_connected"], $arguments);

    }
}
