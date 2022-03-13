<?php

class OrganizerController {

    /**
     * @throws Exception
     */
    public function __construct() {
        if (!isset($_SESSION["id"]) || $_SESSION["role"] === 'ORGANISATEUR') {
            $controller = new ErrorController();
            $controller->error404('/');
            die();
        }
    }
    /**
     * @throws Exception
     */
    public function read(): void {
        // récupérer la campagne en cours, s'il n'y en a pas, montrer la date de la prochaine sinon la montrer
        $my_ideas = array();
        $campaign = array();
        $runningCampaign = CampaignModel::fetchRunningCampaign();
        if (!empty($runningCampaign)) {
            $my_ideas = IdeaModel::fetchUserIdeasFromCampaign($_SESSION["id"], $runningCampaign["CAMPAIGN_ID"]);
            $campaign = CampaignModel::fetchCampaign($runningCampaign["CAMPAIGN_ID"]);
        } else {
            $campaign = CampaignModel::fetchScheduledCampaigns();
            if (!empty($campaign)) {
                $campaign = $campaign[0];
            }
        }

        ViewHelper::display(
            $this,
            'Read',
            array(
                'campaign' => $campaign,
                'ideas' => $my_ideas
            )
        );
    }

    public function readCreate() {
        ViewHelper::display(
            $this,
            'Create',
            array()
        );
    }

    /**
     * @throws Exception
     */
    public function readEdit(int $id): void
    {
        $idea = IdeaModel::fetchTheIdea($id);
        if (empty($idea)) {
            $controller = new ErrorController();
            $controller->error404('/');
        }

        $content = IdeaModel::fetchContents($id);
        ViewHelper::display(
            $this,
            'Edit',
            array(
                'idea' => $idea,
                'content' => $content
            )
        );
    }

    /**
     * @throws Exception
     */
    public function createIdea(): void
    {
        if (empty(CampaignModel::fetchRunningCampaign())) {
            $controller = new ErrorController();
            $controller->error404('/');
            die();
        }

        if (empty($_POST)) {
            $controller = new ErrorController();
            $controller->error404('/');
            die();
        }
        $doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);

        $title = $_POST['title'];
        $description = $_POST['description'];
        $goal = $_POST["goal"];

        // Where the file is going to be placed
        $file = time() . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
        $rel_path = '/images/' . $file;
        $target_path = $doc_root . $rel_path;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            header("HTTP/1.1 500 Internal Server Error");
            die();
        }


        $uid = $_SESSION['id'];
        $cid = -1;
        $campaigns = CampaignModel::fetchCampaigns();
        foreach ($campaigns as $campaign) {
            if ($campaign['Status'] == 'running') {
                $cid = $campaign['ID'];
            }
        };

        if ($cid === -1) {
            header('Location: /');
            die();
        }

        $query = "INSERT INTO IDEA(TITLE, DESCRIPTION, GOAL, PICTURE, USER_ID, CAMPAIGN_ID) VALUES('$title', '$description', '$goal', '$rel_path', '$uid', '$cid')";

        if (Database::executeUpdate($query)) {
            header("Location: /organisateur");
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }

    /**
     * @throws Exception
     */
    public function addContent() {
        if (!isset($_POST)) {
            $controller = new ErrorController();
            $controller->error404('/organisateur');
            die();
        }

        $iid = $_POST['iid'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $goal = $_POST['goal'];

        $query = "INSERT INTO `UNLOCKABLE_CONTENT` (`IDEA_ID`, `TITLE`, `DESCRIPTION`, `POINTS`) VALUES ($iid, '$title', '$description', $goal);";

        if (!Database::executeUpdate($query)) {
            $controller = new ErrorController();
            $controller->error404('/organisateur');
            die();
        }

        header('Location:/organisateur/modifier/'. $iid);
        exit();
    }

    /**
     * @throws Exception
     */
    public function deleteContent() : void {
        if (!isset($_POST)) {
            $controller = new ErrorController();
            $controller->error500('/organisateur');
            die();
        }

        $iid = $_POST['iid'];
        $title = $_POST['title'];

        $query = "DELETE FROM `UNLOCKABLE_CONTENT` WHERE IDEA_ID = $iid AND TITLE = '$title';";

        if (!Database::executeUpdate($query)) {
            $controller = new ErrorController();
            $controller->error500('/organisateur');
            die();
        }

        header('Location: /organisateur/modifier/'.$iid);
        die();
    }
}