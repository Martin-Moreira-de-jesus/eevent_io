<?php

require_once('../Utils/AutoLoader.php');

class AdminController extends AbstractController
{
    /**
     * Verifies au moment de la création du controller, si l'utilisateur à les droits d'administrateur
     * @throws Exception
     */
    public function __construct() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== ADMIN) {
            $controller = new ErrorController();
            $controller->error404('/');
            die();
        }
    }

    public function deleteComment() : void {
        $ideaID = $_POST['ideaid'];
        $commentID = $_POST['commentid'];
        Database::executeUpdate("DELETE FROM COMMENT WHERE COMMENT_ID = $commentID;");
        header('Location: /admin/idee/' . $ideaID);
    }

    public function seeWaitingUser(): void{
        ViewHelper::display(
            $this,
            'ReadWaitingUsers',
            array(
                'emails' => UserModel::getAllEmails(),
                'users' => UserModel::fetchAllWaiting(),
            )
        );
    }

    /**
     * @throws Exception
     */
    public function createUserFromWaitingUser(): void {
        $user = new UserModel();
        $user->setUsername($_POST['username']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setRole($_POST['role']);
        UserModel::createUser($user);
        UserModel::updatePassword($user->getPassword());
        UserModel::deleteWaitingUser($_POST['userID']);
        $content = 'Voici les identifiants de votre nouveau compte '
            . ' nom d\'utilisateur : ' .  $user->getUsername()
            . ' mot de passe : ' . $user->getPassword()
            . ' role : ' . $user->getRole()
            . ' Merci et bonne nuit';
        mail($user->getEmail(), 'Nouveau compte', $content);
        ViewHelper::display(
            $this,
            'ReadUsers',
            array(
                'emails' => UserModel::getAllEmails(),
                'users' => UserModel::fetchAll(),
            )
        );
    }

    public function randomPassword() : string{
        return bin2hex(random_bytes(15));

    }

    /**
     * Ajoute un utilisateur avec un nom d'utilisateur aléatoire et un mot de passe aléatoire hashé
     * @throws Exception
     */
    public function createUser() : void {
        $errors = array(); // eventuelles erreurs seront stockées ici

        $user = new UserModel();

        $user->setUsername(bin2hex(random_bytes(15)));

        while (UserModel::userNameExists($user->getUsername())) {
            $user->setUsername(bin2hex(random_bytes(15)));
        }

        if (empty($errors)) {
            $user->setPassword(bin2hex(random_bytes(15)));

            if (!UserModel::createUser($user)) {
                throw new Error('unexpected');
            }
        }
        ViewHelper::display(
            $this,
            'ReadUsers',
            array(
                'emails' => UserModel::getAllEmails(),
                'users' => UserModel::fetchAll(),
                'errors' => $errors
            )
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function deleteIdea() : void
    {
        $error = array();

        if (isset($_POST['ideaID'])) {
            if (!IdeaModel::deleteIdea($_POST['ideaID'])) {
                $error['error'] = 'Un problème est survenu durant la suppression';
                ViewHelper::display(
                    $this,
                    'Error',
                    array(
                        'path' => '/admin/campaign',
                        'error' => $error
                    )
                );
            }
        } else {
            throw new \http\Exception\RuntimeException('bad access');
        }

        ViewHelper::display(
            $this,
            'Success',
            array(
                'path' => '/admin/campagnes'
            )
        );
    }

    /**
     * Displays all the campaigns
     * @return void
     * @throws Exception
     */
    public function readCampaigns(): void
    {
        $campaigns = CampaignModel::fetchCampaigns();
        ViewHelper::display(
            $this,
            'ReadCampaigns',
            $campaigns
        );
    }

    /**
     * Shows all ideas of a campaign
     * @param $campaignID int the id of the campaign which the ideas belong to
     * @return void
     * @throws Exception
     */
    public function readIdeas(int $campaignID): void
    {
        $campaign = IdeaModel::fetchIdeas($campaignID);
        if (empty($campaign)) {
            $controller = new ErrorController();
            $controller->error404('/');
        }
        ViewHelper::display(
            $this,
            'ReadIdeas',
            $campaign
        );
    }

    /**
     * Show the requested id specified by
     * @param int $ideaID id of the idea to be shown
     * @throws Exception
     */
    public function readIdea(int $ideaID): void
    {
        if (!IdeaModel::ideaExists($ideaID)) {
            $controller = new ErrorController();
            $controller->error404('');
            die();
        }
        $campaign = IdeaModel::fetchAllInfoFromIdea($ideaID);
        ViewHelper::display(
            $this,
            'ReadIdea',
            $campaign
        );
    }

    /**
     * Shows the screen to create a campaign
     * @return void
     * @throws Exception
     */
    public function modifyCampaign(): void
    {
        $errors = array();
        if (!empty($_POST)) {
            /** @var CampaignModel $campaign */
            $campaign = $this->mapDataPostToClass('CampaignModel');
            if (date_create($campaign->getBegDate()) >= date_create($campaign->getEndDate())
                || date_create($campaign->getBegDate()) >= date_create($campaign->getDelibEndDate())) {
                $errors['datebeg'] = 'La date de début ne peux pas être supérieure à la date de fin ou de délibération';
            }

            if (date_create($campaign->getDelibEndDate()) <= date_create($campaign->getEndDate())
                || date_create($campaign->getDelibEndDate()) <= date_create($campaign->getBegDate())) {
                $errors['dateenddelib'] = 'La date de délibétation ne peux pas'
                    . ' être inférieure à la date de fin ou de délibération';
            }

            if (empty($errors) && !CampaignModel::modifyCampaign($campaign)) {
                $errors['unexpected'] = 'Erreur innatendue, contactez le service de maintenance';
            }
        } else {
            throw new \http\Exception\RuntimeException('bad acess');
        }
        $campaign = CampaignModel::fetchCampaign($campaign->getID());
        ViewHelper::display(
            $this,
            'EditCampaign',
            array(
                'errors' => $errors,
                'campaign' => $campaign
            )
        );
    }

    /**
     * @throws ErrorException
     * @throws Exception
     */
    public function createCampaign() : void
    {
        $error = array();
        /** @var CampaignModel $data */

        if (empty($_POST)) throw new ErrorException('bad access');

        $pts = $_POST["pts"];

        $campaign = $this->mapDataPostToClass('CampaignModel');

        if (CampaignModel::checkIfDatesConflicts($campaign)) {
            $error['conflict'] = 'Les dates sont en conflit avec les dates d\'une autre campagne...';
        }

        $begDate = date_create($campaign->getBegDate());
        $endDate = date_create($campaign->getEndDate());
        $delibDate = date_create($campaign->getDelibEndDate());

        if ($begDate > $endDate || $begDate > $delibDate) {
            $error['begdateerror'] = 'La date de début doit être plus petite que la date de fin et de délibération';
        } elseif ($delibDate < $endDate || $delibDate < $begDate) {
            $error['delibdateerror'] = 'La date de délibétation doit $etre plus grande que les deux autres dates';
        }
        if (empty($error)) {
            if (CampaignModel::addCampaign($campaign)) {
                UserModel::addPointsToAllDonors($pts);
                ViewHelper::display(
                    $this,
                    'Success',
                    array(
                        'path' => '.'
                    )
                );
            }
        } else {
            ViewHelper::display(
                $this,
                'CreateCampaign',
                array(
                    'errors' => $error
                )
            );
        }

    }

    /**
     * @param $ideaID
     * @return void
     * @throws Exception
     */
    public function readModifyIdea($ideaID): void
    {
        $idea = IdeaModel::fetchAllInfoFromIdea($ideaID);
        ViewHelper::display(
            $this,
            '',
            $idea
        );
    }

    /**
     * @throws Exception
     */
    public function readModifyCampaign($campaignID): void
    {
        $campaign = CampaignModel::fetchCampaign($campaignID);
        ViewHelper::display(
            $this,
            'EditCampaign',
            array(
                'campaign' => $campaign
            )
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function readUsers(): void
    {
        $users = UserModel::fetchAll();
        ViewHelper::display(
            $this,
            'ReadUsers',
            array(
                'emails' => UserModel::getAllEmails(),
                'users' => $users
            )
        );
    }

    public function readIndex(): void
    {
        ViewHelper::display(
            $this,
            'Index',
            array()
        );
    }

    public function readCreateCampaign() : void
    {
        ViewHelper::display(
            $this,
            'CreateCampaign',
            array()
        );
    }

    /**
     * Modifie un utilisateur selon les valeurs dans $_POST,
     * @throws Error envoyée si l'utilisateur à tenté de rentrer les values $_GET directement à la main, une erreur est donc renvoyée
     * @throws Exception erreurs sql
     */
    public function editUser() : void
    {
        $errors = array();

        if (empty($_POST)) {
            throw new Error("bad access");
        }

        /** @var UserModel $user */
        $user = UserModel::constructFromArray($_POST);

        var_dump($user);die();

        if (UserModel::usernameAlreadyExists($user->getUserID(), $user->getUserName())) {
            $errors['username_exists'] = 'The username selected already exists';
        }

        if (empty($errors)) {
            if (UserModel::updateUser($user)) {
                ViewHelper::display(
                    $this,
                    'ReadUsers',
                    array(
                        'users' => UserModel::fetchAll(),
                        'emails' => UserModel::getAllEmails()
                    )
                );
            } else {
                $errors['unexpected_error'] = 'Erreur innatendue, contactez l\'équipe de maintenance';
            }
        }
        ViewHelper::display(
            $this,
            'ReadUsers',
            array(
                'users' => UserModel::fetchAll(),
                'errors' => $errors,
                'emails' => UserModel::getAllEmails()
            )
        );
    }
}