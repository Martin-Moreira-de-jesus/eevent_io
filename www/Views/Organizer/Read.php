<?php
/** @var array $data */
$campaign = $data["campaign"];
$idea = $data["ideas"];
start_page("OrgaView");
navbar();
if (!empty($campaign)) {
    /** @var CampaignModel $campaign */
    $campaign = CampaignModel::constructFromArray($campaign);
    if ($campaign->getStatus() === 'running') { ?>
    <div class="container">
        <p class="text-justify">
            <strong>
                Votre rôle est celui de l'organisateur,

                Vous êtes le pilier de ce serveur, la raison pour laquelle nous avons mis en place cet environnement.

                Vous êtes ici pour laisser place à votre imagination, créer sans peur ni crainte, soyez vous-même et produisez la meilleure idée possible pour remporter ce concours !

                Vous pouvez, si vous le souhaitez,  ajouter du contenu additionnel pour augmenter l'engouement autour de votre projet.

                Pour que votre idée soit validée il faut que suffisamment de donateurs vous soutiennentt, par la suite le jury décidera des idées les plus méritantes.

                N'oubliez pas que le plus important est de prendre du plaisir dans ce que vous entreprenez, respect les autres candidats et bonne chance !
            </strong>
        </p>
    <table class="bd-grey striped">
        <caption><h3>Campagne en cours</h3></caption>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Date de fin de délibération</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $campaign->getTitle() ?></td>
                <td><?php echo $campaign->getBegDate() ?></td>
                <td><?php echo $campaign->getEndDate() ?></td>
                <td><?php echo $campaign->getDelibEndDate() ?></td>
            </tr>
        </tbody>
    </table>

        <?php if (!empty($idea)) { ?>
    <table class="bd-grey striped">
        <caption><h3>Mes Idées</h3></caption>
        <thead>
            <tr>
                <th>Titre</th>
                <th>But</th>
                <th>Points</th>
                <th>Modifier</th>
            </tr>
        </thead>
            <tr>
                <td><?php echo $idea["TITLE"] ?></td>
                <td><?php echo $idea["GOAL"] ?></td>
                <td><?php echo $idea["TOTAL_POINTS"] ?></td>
                <td><a href="organisateur/modifier/<?php echo $idea["IDEA_ID"];?>">Modifier</a></td>
            </tr>
        </table>
    </div>
<?php } else {  // !empty($ideas) ?>
    <h1 class="is-center">Vous n'avez créée aucune idée</h1>
            <a class="is-center" href="/organisateur/creer">
                Créer une idée
            </a>
            <?php
        } ?>
    <?php } // $campaign->getStatus() === 'running'
} else { // !empty($campaign) ?>
    <h1 class="text-center">Pas de campagnes en cours, ni prévues</h1>
    <a class="is-center" href="/">Retourner à l'accueil</a>
<?php
}
end_page();
?>