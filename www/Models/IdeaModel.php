<?php

require_once('../Utils/Database.php');

class IdeaModel extends AbstractModel{

    private int $ID;
    private string $title;
    private string $description;
    private int $goal;
    private int $totalVotes;
    private int $totalPoints;
    private string $picture;
    private int $userID;
    private int $campaignID;

    /**
     * @throws Exception
     */
    public static function fetchRealizedIdeas(int $campaignID) : array {
        $result = Database::executeQuery("SELECT * FROM IDEA WHERE REALISED = 1 AND CAMPAIGN_ID = $campaignID");
        return empty($result) ? array() : $result;
    }

    public static function updateRealized($ideaId)
    {
        Database::executeUpdate("UPDATE IDEA SET REALISED = 1 WHERE IDEA_ID='$ideaId';");
    }

    public static function ideaExists($ideaID) : bool {
        return Database::executeCount("SELECT COUNT(*) FROM IDEA WHERE IDEA_ID = $ideaID");
    }

    /**
     * @throws Exception
     */
    public static function fetchIdeas(int $campaignID) : ?array {
        return Database::executeQuery("SELECT * FROM `idea` WHERE CAMPAIGN_ID = "
            . $campaignID . " ORDER BY TOTAL_POINTS DESC;");
    }

    public static function fetchTheIdea($ideaID) : array {
        $result = database::executeQuery("SELECT * FROM IDEA WHERE IDEA_ID = $ideaID;");
        return empty($result) ? array() : $result[0];
    }

    public static function fetchUserIdeasFromCampaign(int $userID, int $campaignID) : array {
        $result = Database::executeQuery("SELECT * FROM IDEA WHERE USER_ID = $userID AND CAMPAIGN_ID = $campaignID");
        return empty($result) ? array() : $result[0];
    }

    public static function fetchUserIdeas(int $userID) : array {
        return Database::executeQuery("SELECT * FROM IDEA WHERE USER_ID = $userID");
    }

    /**
     * @throws Exception
     */
    public static function fetchIdeasDelib() : array {
        $query = "SELECT CAMPAIGN_ID FROM CAMPAIGN WHERE `STATUS` = 'deliberation';";
        $campaign = Database::executeQuery($query);

        return Database::executeQuery("SELECT * FROM `idea` WHERE CAMPAIGN_ID = "
            . $campaign[0]['CAMPAIGN_ID'] . " AND GOAL <= TOTAL_POINTS ORDER BY TOTAL_POINTS DESC;");
    }

    /**
     * @throws Exception
     */
    public static function fetchAllInfoFromIdea($ideaID) : array {
        $data = array();

        $result = self::fetchTheIdea($ideaID);
        if (empty($result)) {
            return array();
        }
        $data["IDEA"] = $result;

        $data["USER"] = Database::executeQuery("SELECT USER.USER_ID, USER.USERNAME FROM USER, IDEA WHERE USER.USER_ID = IDEA.USER_ID")[0];

        $data["COMMENTS"] = Database::executeQuery("SELECT * FROM COMMENT WHERE IDEA_ID = $ideaID");

        $usernames = Database::executeQuery("SELECT USERNAME FROM USER, COMMENT WHERE USER.USER_ID = COMMENT.USER_ID");
        for ($i = 0, $iMax = count($data["COMMENTS"]); $i < $iMax; ++$i) {
            $data["COMMENTS"][$i]["USERNAME"] = $usernames[$i]["USERNAME"];
        }

        $data["CONTENTS"] = Database::executeQuery("SELECT * FROM UNLOCKABLE_CONTENT WHERE IDEA_ID = $ideaID");

        return $data;
    }

    public  static function acceptIdea($id){
        Database::executeUpdate("UPDATE IDEA SET REALIZED = '1' WHERE IDEA_ID = $id ;");
    }

    /**
     * @throws Exception
     */
    public static function deleteIdea(int $ideaID): bool
    {
        return Database::executeUpdate("
            DELETE FROM IDEA
            WHERE IDEA_ID = $ideaID;
        ");
    }

    public static function isInDeliberation($idea_id) {
        $query = "SELECT STATUS FROM CAMPAIGN, IDEA WHERE CAMPAIGN.CAMPAIGN_ID = IDEA.CAMPAIGN_ID AND IDEA_ID = $idea_id;";
        $result = Database::executeQuery($query)[0];

        return $result["STATUS"] === 'deliberation';
    }

    /**
     * @throws Exception
     */
    public static function isOldCampaign($idea_id) : bool
    {
        $query = "SELECT STATUS FROM CAMPAIGN, IDEA WHERE CAMPAIGN.CAMPAIGN_ID = IDEA.CAMPAIGN_ID AND IDEA_ID = $idea_id;";
        $result = Database::executeQuery($query)[0];

        return $result["STATUS"] === 'over';
    }

    /**
     * @throws Exception
     */
    public static function fetchContents(int $id) : array
    {
        $contents = Database::executeQuery("SELECT * FROM UNLOCKABLE_CONTENT WHERE IDEA_ID = $id;");
        return empty($contents) ? array() : $contents;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @param int $ID
     */
    public function setID(int $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getGoal(): int
    {
        return $this->goal;
    }

    /**
     * @param int $goal
     */
    public function setGoal(int $goal): void
    {
        $this->goal = $goal;
    }

    /**
     * @return int
     */
    public function getTotalVotes(): int
    {
        return $this->totalVotes;
    }

    /**
     * @param int $totalVotes
     */
    public function setTotalVotes(int $totalVotes): void
    {
        $this->totalVotes = $totalVotes;
    }

    /**
     * @return int
     */
    public function getTotalPoints(): int
    {
        return $this->totalPoints;
    }

    /**
     * @param int $totalPoints
     */
    public function setTotalPoints(int $totalPoints): void
    {
        $this->totalPoints = $totalPoints;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @param int $userID
     */
    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return int
     */
    public function getCampaignID(): int
    {
        return $this->campaignID;
    }

    /**
     * @param int $campaignID
     */
    public function setCampaignID(int $campaignID): void
    {
        $this->campaignID = $campaignID;
    }


}
