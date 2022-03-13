<?php
start_page("test");
navbar();
/** @var array $data */
if (isset($data['ideas'])) {
    $ideas = $data['ideas'];
}
if (isset($data['next_campaign'])) {
    $nextCampaign = $data['next_campaign'];
}
if (isset($data['last_campaign_result'])) {
    $lastCampaignResults = $data['last_campaign_result'];
}
if (isset($data['ideas_delib'])) {
    $currentDeliberation = $data['ideas_delib'];
}
if (isset($data['option'])) {
    $option = $data['option'];
}
?>
    <div class="container" style="margin-top: 5px">
        <p class="text-justify">
            <strong>
            Bonjour à tous et à toutes !

            Bienvenue sur E-Event Io, c'est un lieu merveilleux dédié à la créativité et l'amusement.

            Ici les spécialités sont : les concours d'idées . Nous sommes ici pour découvrir et entreprendre nos rêves les plus fous.

            Veuillez à bien respecter ce qui vous entoure et leurs idées, et surtout ... Amusez-vous bien !
            </strong>
        </p>
        <?php if (!empty($ideas)) { ?>
        <table class="bd-grey striped">
            <caption class="text-center"><h3>Liste des idées disponibles</h3></caption>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>But</th>
                    <th>Points</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($ideas as $idea) { ?>
                <tr>
                    <td><img height="100" width="100" src="<?php echo $idea["PICTURE"] ?>" alt="l'image n'à pas pu être affichée"></td>
                    <td><?php echo $idea["TITLE"] ?></td>
                    <td><?php echo $idea["GOAL"] ?></td>
                    <td><?php echo $idea["TOTAL_POINTS"] ?></td>
                    <td><a href="idee/<?php echo $idea["IDEA_ID"] ?>">Voir</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php } else {
            if ($option === 'none') { ?>
        <h3 class="text-center">Pas d'idées dans la campagne en cours</h3>
            <?php } else if ($option === 'no_campaigns_scheduled') { ?>
        <h3 class="text-center">Pas de campagnes prévues, restez à l'écoute...</h3>
            <?php } else if ($option === 'campaign_scheduled') { ?>
        <h3 class="text-center">Pas de campagne en cours... prochaine campagne prévue le <?php echo $nextCampaign["BEG_DATE"] ?></h3>
            <?php }
        } ?>
        <?php if (isset($currentDeliberation) && !empty($currentDeliberation)) { ?>
        <table class="bd-grey striped" style="margin-top: 2em">
            <caption><h3>Liste des idées actuellement en délibération</h3></caption>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Status</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($currentDeliberation as $idea) { ?>
                <tr>
                    <td><?php echo $idea["TITLE"] ?></td>
                    <td>Status : <?php echo $idea["REALISED"] == 1 ? 'Acceptée' : 'En délibération' ?></td>
                    <td><a href="idee/<?php echo $idea["IDEA_ID"] ?>">Voir</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php } if (!empty($lastCampaignResults)) { ?>
        <table class="bd-grey striped" style="margin-top: 2em">
            <caption><h3>Liste des idées acceptées durant la dernière campagne</h3></caption>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($lastCampaignResults as $idea) { ?>
                <tr>
                    <td><?php echo $idea["TITLE"] ?></td>
                    <td><a href="idee/<?php echo $idea["IDEA_ID"] ?>">Voir</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
<?php
end_page();
?>