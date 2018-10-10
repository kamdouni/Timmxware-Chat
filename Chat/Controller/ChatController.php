<?php
namespace Controller;

use Config\Connexion;
use Repository\ChatRepository;
use Repository\UserRepository;
use View\Template;

class ChatController
{
    /**
     *
     */
    public function index()
    {
        $connexion = new Connexion();
        $messageRepository = new ChatRepository($connexion);
        $messages = $messageRepository->find();
        $_SESSION["messages"] = $messages;

        $userRepository = new UserRepository($connexion);
        $users = $userRepository->find(['is_connected' => 1]);
        $_SESSION["users"] = $users;

        ob_start();
        include '/../View/chat.php';
        ob_end_flush();
    }

    /**
     * add message
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $connexion = new Connexion();
            $messageRepository = new ChatRepository($connexion);
            $userRepository = new UserRepository($connexion);
            $user = $userRepository->findOne(['pseudo' => $_SESSION['pseudo']]);

            $params = [$user->getId(), "'" . $_POST['message'] . "'", "'" . (new \DateTime())->format('Y-m-d H:m:s') . "'"];
            $messageRepository->addData($params);
            header('Location: chat');
        }
    }

    /**
     * refresh
     */
    public function refresh()
    {

        $connexion = new Connexion();
        $messageRepository = new ChatRepository($connexion);
        $userRepository = new UserRepository($connexion);

        $messages = $messageRepository->find();
        $users = $userRepository->find();

        $result = [];
        $result['messages'] = $messages;
        $result['users'] = $users;
        echo json_encode($result);
    }
}
