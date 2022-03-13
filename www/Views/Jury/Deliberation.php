<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page("test");
/** @var array $data */
$option = $data['option'];
$campaign = $data['campaign'];
$ideas = $data['ideas'];
navbar();
if(!empty($ideas)){
    ?>
    <div class="container" style="margin-top: 5px">
        <p class="text-justify">
            <strong>
                Votre rôle est celui du jury,
                votre tâche est très importante, c'est à vous de départager les idées qui sont déjà validés par nos amis les donateurs.
                C'est à vous de vous accorder dans vos choix et vos idées. Mais attention prenez garde, une fois une idée validée il est impossible de faire machine arrière, cette idée sera également validée pour tout le monde.
                Prenez du bon temps, respectez les autres participants et amusez-vous !
            </strong>
        </p>
        <table>
            <thead>
            <tr>
                <th>Voici les idées rangées par ordre de réalisation</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($ideas as $idea) { ?>
                <tr>
                    <td>Mettre image ici</td>
                    <td><?php echo $idea["TITLE"] ?></td>
                    <td>Goal : <?php echo $idea["GOAL"] ?></td>
                    <td>Current Points : <?php echo $idea["TOTAL_POINTS"] ?></td>
                    <td><a href="jury/idee/<?php echo $idea["IDEA_ID"] ?>">Voir</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
}
else{
    if (empty($campaign)) { ?>
    <h3 class="text-center">Pas de campagnes en cours</h3>
<?php } else if ($option === 'no_ideas') { ?>
    <h3 class="text-center">Aucune idées n'ont été assez populaires</h3>
    <?php
    } ?>
    <a class="is-center" href="/"><button type="button"> Page d'accueil</button></a>
<?php }
end_page();
?>