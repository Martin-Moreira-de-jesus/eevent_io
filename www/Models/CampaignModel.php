<?php

require_once('../Utils/Database.php');

class CampaignModel extends AbstractModel
{
    private int $ID;
    private string $title;
    private string $begDate;
    private string $endDate;
    private string $delibEndDate;
    private string $status;

    public static function fetchLastFinishedCampaign() : array {
        $result = Database::executeQuery("SELECT * FROM CAMPAIGN WHERE `STATUS` = 'over' ORDER BY DELIB_END DESC;");
        return empty($result) ? array() : $result[0];
    }

    public static function fetchScheduledCampaigns() : array {
        return Database::executeQuery("SELECT * FROM CAMPAIGN WHERE `STATUS` = 'scheduled' ORDER BY BEG_DATE;");
    }

    /**
     * @param $campaignID
     * @return bool
     */
    public static function modifyCampaign(CampaignModel $campaign): bool
    {
        return Database::executeUpdate("
        UPDATE CAMPAIGN
        SET
            BEG_DATE = '$campaign->begDate',
            END_DATE = '$campaign->endDate',
            DELIB_END = '$campaign->delibEndDate',
            TITLE = '$campaign->title'
        WHERE
            CAMPAIGN_ID = $campaign->ID;
        ");
    }
    public  static function fetchMaxVoteJury(){
        $query = Database::executeQuery("SELECT MAX_VOTE_JURY FROM CAMPAIGN WHERE STATUS='deliberation'")[0];
        return $query['MAX_VOTE_JURY'];
    }



//    public  static  function removeMaxVoteJury(){
//        Database::executeUpdate("UPDATE CAMPAIGN SET MAX_VOTE_JURY = MAX_VOTE_JURY - 1 WHERE  = '$password';");
//    }

    public static function fetchCampaignInDeliberation() : array
    {
        $result = Database::executeQuery("SELECT * FROM CAMPAIGN WHERE `STATUS` = 'deliberation';");
        return empty($result) ? array() : $result[0];
    }



    public static function fetchRunningCampaign() : array {
        $result = Database::executeQuery("SELECT CAMPAIGN_ID FROM CAMPAIGN WHERE STATUS = 'RUNNING';");
        return empty($result) ? array() : $result[0];
    }

    /**
     * @throws Exception
     */
    public static function checkIfDatesConflicts(CampaignModel $campaign): bool
    {
        $campaigns = self::fetchCampaigns();
        /** @var CampaignModel $n_campaign */
        foreach ($campaigns as $c) {
            $n_campaign = self::constructFromArray($c);
            if (($campaign->getBegDT() <= $n_campaign->getBegDT() && $campaign->getEndDT() >= $n_campaign->getEndDT())
                || ($campaign->getBegDT() >= $n_campaign->getBegDT() && $campaign->getBegDT() <= $n_campaign->getEndDT())
                || ($campaign->getEndDT() >= $n_campaign->getBegDT() && $campaign->getEndDT() <= $n_campaign->getEndDT())
                || ($campaign->getDelibEndDT() >= $n_campaign->getEndDT() && $campaign->getDelibEndDT() <= $n_campaign->getDelibEndDT())
                || ($campaign->getDelibEndDT() >= $n_campaign->getEndDT() && $campaign->getEndDT() <= $n_campaign->getBegDT())) {
                return true;
            }

        }
        return false;
    }

    /**
     * @throws Exception
     */
    public static function addCampaign(CampaignModel $campaign): bool
    {
        return Database::executeUpdate("
            INSERT INTO
                CAMPAIGN(TITLE, BEG_DATE, END_DATE, DELIB_END)
            VALUES (
                '$campaign->title',
                '$campaign->begDate',
                '$campaign->endDate',
                '$campaign->delibEndDate'
            );
        ");
    }

    /**
     * @throws Exception
     */
    public static function fetchCampaigns(): array
    {
        return Database::executeQuery("SELECT CAMPAIGN_ID AS ID, BEG_DATE AS BegDate, END_DATE as EndDate,"
            . "DELIB_END AS DelibEndDate, TITLE AS Title, STATUS AS Status FROM CAMPAIGN;");
    }

    /**
     * @param int $campaignID id of the campaign to extract from the database
     * @return array
     * @throws Exception
     */
    public static function fetchCampaign(int $campaignID): array
    {
        return Database::executeQuery("SELECT CAMPAIGN_ID AS ID, BEG_DATE AS BegDate, END_DATE as EndDate,"
            . "DELIB_END AS DelibEndDate, TITLE AS Title, STATUS AS Status FROM CAMPAIGN WHERE CAMPAIGN_ID = $campaignID")[0];
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
    public function getBegDate(): string
    {
        return $this->begDate;
    }

    /**
     * @param string $begDate
     */
    public function setBegDate(string $begDate): void
    {
        $this->begDate = $begDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDelibEndDate(): string
    {
        return $this->delibEndDate;
    }

    /**
     * @param string $delibEndDate
     */
    public function setDelibEndDate(string $delibEndDate): void
    {
        $this->delibEndDate = $delibEndDate;
    }

    /**
     * @return bool
     */
    public function isOver(): bool
    {
        return $this->status === 'over';
    }

    /**
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->status === 'running';
    }

    /**
     * @return bool
     */
    public function isInDeliberation(): bool
    {
        return $this->status === 'deliberation';
    }

    /**
     * @return bool
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function getBegDT(): DateTime
    {
        return date_create($this->begDate);
    }

    public function getEndDT(): DateTime
    {
        return date_create($this->endDate);
    }

    public function getDelibEndDT(): DateTime
    {
        return date_create($this->delibEndDate);
    }
}