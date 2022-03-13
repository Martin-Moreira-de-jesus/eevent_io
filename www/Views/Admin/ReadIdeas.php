<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page("test");
/** @var array $data */
$ideas = $data;
navbar();
returnButton('.');
if (empty($ideas)) {
    echo "<h2>Aucune idées n'ont été publiées dans cette campagne !</h2>";
} else {
?>
    <div class="container" style="margin-top: 5px">
        <table class="bd-grey striped">
            <caption><h3>Idées</h3></caption>
            <thead>
            <tr>
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
                    <td><?php echo $idea["TITLE"] ?></td>
                    <td>Goal : <?php echo $idea["GOAL"] ?></td>
                    <td>Current Points : <?php echo $idea["TOTAL_POINTS"] ?></td>
                    <td><a href="/admin/idee/<?php echo $idea['IDEA_ID'] ?>">Voir</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
<?php
} // else
end_page();
?>