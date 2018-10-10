<?php
namespace Model;

use Config\Connexion;
use DateTime;
use Repository\UserRepository;

/**
 * Class Chat
 */
class Chat
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var User
     */
    protected $sender;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var DateTime
     */
    protected $sendAt;

    /**
     * Chat constructor.
     * @param $data
     */
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'send_at') {
                $this->sendAt = $value;
            } elseif ($key == 'sender') {
                $connexion = new Connexion();
                $userRepository = new UserRepository($connexion);
                $user = $userRepository->findOne(['id' => $value]);
                $this->sender = new User($user);
            } else {
                $this->$key = $value;
            }
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
     * @return Chat
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     * @return Chat
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Chat
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

    /**
     * @param DateTime $sendAt
     * @return Chat
     */
    public function setSendAt($sendAt)
    {
        $this->sendAt = $sendAt;

        return $this;
    }
}