<?php
namespace Model;

/**
 * Class User
 */
class User
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $pseudo;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var bool
     */
    protected $isConnected = false;

    /**
     * User constructor.
     * @param int $id
     * @param string $pseudo
     * @param string $password
     * @param bool $isConnected
     */
    public function __construct($data)
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     * @return User
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isConnected()
    {
        return $this->isConnected;
    }

    /**
     * @param boolean $isConnected
     * @return User
     */
    public function setIsConnected($isConnected)
    {
        $this->isConnected = $isConnected;

        return $this;
    }
}