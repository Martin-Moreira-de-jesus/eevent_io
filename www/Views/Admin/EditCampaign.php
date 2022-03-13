<?php
start_page("test");
navbar();
returnButton('..');
/** @var array $data */
$campaign = CampaignModel::constructFromArray($data['campaign']);
if (isset($data['errors'])) {
    $errors = $data['errors'];
}
if (isset($errors)) { ?>
    <div>
<?php foreach ($errors as $error) { ?>

        <p><?php echo $error ?></p>

<?php } ?>
    </div>
<?php } ?>
    <div class ="container bd-grey" style="padding: 15px">
        <form action="?controller=Admin&action=modifyCampaign" method="post">
            <input type="hidden" name="ID" value="<?php echo $campaign->getID() ?>">
            <label for="title"><strong>Titre actuel : <?php echo $campaign->getTitle();?></strong></label>
            <input id="title"
                   type="text"
                   name="title"
                   value="<?php echo $campaign->getTitle();?>"
                   placeholder="<?php echo $campaign->getTitle();?>"
                    <?php if ($campaign->isOver()) {echo 'readonly';} ?>>

            <label for="beg_date"><strong>Changer la date de début : </strong></label>
            <input type="date" id="beg_date" name="begdate"
                   value="<?php echo $campaign->getBegDate() ?>" min="<?php echo date('Y-m-d') ?>"
                    <?php if (!$campaign->isScheduled()) {echo 'readonly';}?>>

            <label for="end_date"><strong> Changer la date de fin : </strong></label>
            <input type="date" id="end_date" name="enddate"
                   value="<?php echo $campaign->getEndDate() ?>" min="<?php echo date('Y-m-d') ?>"
                    <?php if ($campaign->isOver() || $campaign->isInDeliberation()) echo 'readonly'?>>

            <label for="delib_date"><strong>Changer la date de fin de délibération : </strong></label>
            <input type="date" id="delib_date" name="delibenddate"
                   value="<?php echo $campaign->getDelibEndDate() ?>"
                <?php if ($campaign->isOver()) echo 'readonly'?>>
            <input id="send_form" type="submit" value="modifier" style="margin-top: 10px">
        </form>
    </div>