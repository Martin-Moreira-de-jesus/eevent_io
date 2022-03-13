<?php

class DonatorController
{
    public function userComment(): void
    {
        $errors = array();
        $comment = $_POST["comment"];
        $ideaID = $_POST["ideaID"];
        $userID = $_SESSION['id'];
        if ($comment === ''){
            $errors['noComment'] = 'Vous ne pouvez pas publier un message vide !';
        }
        else{
            if (str_contains($comment, "'" ))
            {
                $comment = str_replace("'","\'", $comment);
            }

            Database::executeUpdate("INSERT INTO `comment` (idea_id, user_id, comment) VALUES ('$ideaID', '$userID', '$comment')");
        }
        $idea = IdeaModel::fetchAllInfoFromIdea($ideaID);
        ViewHelper::display(
            $this,
            'readOne',
            array('errors' => $errors,
                'idea' => $idea)
        );
    }
    /**
     * Verifies au moment de la création du controller, si l'utilisateur à les droits d'administrateur
     * @throws Exception
     */
    public function __construct() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== DONOR) {
            $controller = new ErrorController();
            $controller->error404('/');
            die();
        }
    }

    /**
     * @throws Exception
     */
    public function userVote(): void
    {
        $errors = array();
        $pts = (int)$_POST["pts"];
        $ideaID = $_POST["ideaID"];
        $totalPointsUser = UserModel::fetchUser($_SESSION['id'])['POINTS'];

        if ($pts > $totalPointsUser) {
            $errors['notenough'] = 'Vous ne possedez pas le nombre de points suffisant !';
        }
        else {
            Database::executeUpdate("UPDATE IDEA SET TOTAL_POINTS = TOTAL_POINTS + $pts WHERE IDEA_ID = " . $ideaID);
            Database::executeUpdate("UPDATE USER SET POINTS = POINTS - $pts WHERE USER_ID = " . $_SESSION['id']);
            }

        $idea = IdeaModel::fetchAllInfoFromIdea($ideaID);
        $idea['errors'] = $errors;
        ViewHelper::display(
            $this,
            'readOne',
            array('errors' => $errors,
                'idea' => $idea)
        );
    }


}