<?php
include('../Utils/AutoLoader.php');

$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);

class UserController
{
    public function __construct()
    {
    }

    public function changePassword(){
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        $controller = new ErrorController();

        if (UserModel::fetchPassword($oldPassword))
        {
            if ($newPassword == $confirmPassword)
            {
                UserModel::updatePassword($confirmPassword);
                header('Location: /');
                exit();
            }
            else
                $controller->error404('/');
        }
        else
            $controller->error404('/');
    }

    public  function setVoteJury(){
        UserModel::updatePoint(intdiv((int)CampaignModel::fetchMaxVoteJury(),UserModel::countJury()));
    }

    /**
     * @throws Exception
     */
    public function login()
    {
        $loginError = null;

        $login = $_POST['login'];
        $password = $_POST['password'];
        $model = new UserModel();

        if(isset($_SESSION['user'])) {
            header('Location: /');
            exit();
        }
        if (UserModel::userNameExists($login)) {
            if ($model->isPassword($login, $password)) {
                $_SESSION['user'] = $login;
                $_SESSION['id']= UserModel::fetchId($login);
                $_SESSION['role']= UserModel::fetchRole($login);
                $_SESSION['points'] = UserModel::fetchPoints($login);
                header('Location: /'); //  #TODO remplacer "test" par le fichier qui accueil l'utilisateur qui se connecte
                 exit();
            }
            $loginError = 'Nom d\'utilisateur ou mot de passe incorrect';
        }
        else {
            $loginError = 'Nom d\'utilisateur ou mot de passe incorrect';
        }

        ViewHelper::display(
            $this,
            'Login',
            array(
                'loginError' =>  $loginError,
            )
        );
    }

    public function logout(){
        session_destroy();
        header('Location: /');
        die();
    }

    public function sendEmailAdmin($username, $userEmail)
    {
       $email = UserModel::getEmailAdmin();
       mail($email,
           'Change Password',
           'You have to change' . $username . '\'s password. Send it at : ' . $userEmail . '.');

    }

    public function RegisterLoginEmail()
    {
        header('Location : AskLoginEmail');
        exit();
    }

    public function read() : void {
        $users = UserModel::fetchAll();
        ViewHelper::display(
            $this,
            'Read',
            $users
        );
    }

    public function editUser(int $id) : void
    {
        $user = UserModel::fetchUser($id);
        ViewHelper::display(
            $this,
            'Edit',
            $user
        );
    }

    public function index() : void
    {
        if(!empty($_SESSION)) {
            header('Location: /');
            exit();
        }

        ViewHelper::display(
        $this,
            'Login',
            array()
        );
    }

    public function indexPassword() : void
    {
        ViewHelper::display(
            $this,
            'PasswordChange',
            array()
        );
    }

    public function askRegistration() : void {
        $errors = array(); // eventuelles erreurs seront stockées ici
        $user = new UserModel();
        $user->setUsername($_POST['username']);
        $user->setRole($_POST['role']);
        $user->setEmail($_POST['email']);
        if (empty($errors)) {
            UserModel::createWaitingUser($user);
        }
        ViewHelper::display(
            $this,
            'RegistrationSent',
            array(
            )
        );
    }

    /**
     * @throws Exception
     */
    public function askRegistrationForgotten() : void {
        $oldID = UserModel::fetchId($_POST['username']);
        UserModel::deleteUser($oldID);
        $errors = array(); // eventuelles erreurs seront stockées ici
        $user = new UserModel();
        $user->setUsername($_POST['username']);
        $user->setRole($_POST['role']);
        $user->setEmail($_POST['email']);
        if (empty($errors)) {
            UserModel::createWaitingUser($user);
        }
        ViewHelper::display(
            $this,
            'RegistrationSent',
            array(
            )
        );
    }

    public function registration() : void
    {
        if(!empty($_SESSION)) {
            header('Location: /');
            exit();
        }

        ViewHelper::display(
            $this,
            'Registration',
            array()
        );
    }
    public function PasswordChange() : void
    {
        ViewHelper::display(
            $this,
            'PasswordChange',
            array()
        );
    }

    public function PasswordForgotten() : void
    {
        if(!empty($_SESSION)) {
            header('Location: /');
            exit();
        }

        ViewHelper::display(
            $this,
            'PasswordForgotten',
            array()
        );
    }
}
