<?php
start_page("test");
navbar();
returnButton('.');
/** @var array $data */
$campaigns = $data;
for ($i = 0, $iMax = count($campaigns); $i < $iMax; ++$i) {
    $campaigns[$i] = CampaignModel::constructFromArray($campaigns[$i]);
}
?>
    <div class="container" style="margin-top: 5px">
        <h1 class="text-center"> Campagnes en cours </h1>
        <table class="bd-grey striped">
            <thead>
                <tr>
                    <td>Titre</td>
                    <td>Date de début</td>
                    <td>Date de fin</td>
                    <td>Date fin délib</td>
                    <td>Voir les idées</td>
                    <td>Modifier</td>
                </tr>
            </thead>
            <tbody>
                <?php
                /** @var CampaignModel $campaign */ foreach ($campaigns as $campaign) { ?>
                    <tr>
                        <td><?php echo $campaign->getTitle() ?></td>
                        <td><?php echo $campaign->getBegDate() ?></td>
                        <td><?php echo $campaign->getEndDate() ?></td>
                        <td><?php echo $campaign->getDelibEndDate() ?></td>
                        <td><a href="campagnes/<?php echo $campaign->getID() ?>" class="button error">Voir</a></td>
                        <td><a href="campagnes/<?php echo $campaign->getID() ?>/modifier" class="button error">Modifier</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a style="margin-top: 10px" class="col-12 row is-center" href="campagnes/creer"><button>Creer une nouvelle campagne</button></a>
    </div>
<?php
end_page();
?>