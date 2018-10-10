<?php
namespace Controller;

use Config\Connexion;
use Model\User;
use Repository\UserRepository;

/**
 * Class AuthentificationController
 * @package Controller
 */
class AuthentificationController
{
    /**
     * login
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $connexion = new Connexion();
            $userRepository = new UserRepository($connexion);
            $user = $userRepository->findOne(['pseudo' => $_POST['pseudo']]);

            if ($user instanceof User) {
                if (!$this->correctPassword($_POST['password'], $user->getPassword())) {
                    echo 'erreur';
                    $this->showAuhtentificatePage();
                    exit;
                }
                $_SESSION["pseudo"] = $user->getPseudo();
                $userRepository->setStatus($_SESSION["pseudo"], 1);
                header('Location: chat');
            } else {
                $pseudo = $_POST['pseudo'];
                $password = sha1($_POST['password']);
                $userRepository->addUser(["'$pseudo'", "'$password'", 1]);
                $_SESSION["pseudo"] = $pseudo;
                header('Location: chat');
            }
        }

        $this->showAuhtentificatePage();
    }

    /**
     * redirect view
     */
    protected function showAuhtentificatePage()
    {
        ob_start();
        include '/../View/authentification.php';
        ob_end_flush();
    }

    /**
     * @param $password
     * @param $cryptedPassword
     * @return bool
     */
    protected function correctPassword($password, $cryptedPassword)
    {
        if (sha1($password) == $cryptedPassword) {

            return true;
        }

        return false;
    }

    /**
     * logout
     */
    public function logout()
    {
        $connexion = new Connexion();
        $userRepository = new UserRepository($connexion);
        $userRepository->setStatus($_SESSION["pseudo"], 0);
        $_SESSION["pseudo"] = null;
        header('Location: login');
    }

}
