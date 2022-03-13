<?php

class JuryController {
    /**
     * @throws Exception
     */

    public function __construct()
    {
        $controller = new ErrorController();
        if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'jury'){
            $controller->error404('/');
            die();
        }
    }

    public function read(): void
    {
        $campaignInDelib = CampaignModel::fetchCampaignInDeliberation();
        $option = 'none';
        if (empty($campaignInDelib)) {
            $option = 'no_campaign';
            $ideas = array();
        } else {
            $ideas = IdeaModel::fetchIdeasDelib();
        }

        if (empty($ideas)) {
            $option = 'no_ideas';
        }

        ViewHelper::display(
            $this,
            'Deliberation',
            array (
                'option' => $option,
                'ideas' => $ideas,
                'campaign' => $campaignInDelib
            )
        );
    }

    public function juryVote(){
        $id = $_POST['ideaID'];
        IdeaModel::updateRealized($id);
        ViewHelper::display(
            $this,
            'ReadOne',
            array(
                'VOTE' => 1
            )
        );
        header('Location: /jury/idee/'.$id);
        exit();
    }

    /**
     * @throws Exception
     */
    public function readOne($id) : void {
        $idea = IdeaModel::fetchAllInfoFromIdea($id);
        $campaign = CampaignModel::fetchCampaignInDeliberation();
        if(empty($idea)) {
            $controller = new ErrorController();
            $controller->error404('');
            exit();
        }
        ViewHelper::display(
            $this,
            'ReadOne',
            array(
                'IDEA' => $idea,
                'CAMPAIGN' => $campaign
            )
        );
    }
}