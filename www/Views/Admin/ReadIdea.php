<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page("test");
/** @var array $data */
$idea = $data["IDEA"];
if (isset($data["COMMENTS"])) {
    $comments = $data["COMMENTS"];
}
if (isset($data["CONTENTS"])) {
    $users = $data["CONTENTS"];
}
navbar();
returnButton('.');
?>
    <div class="container" style="margin-top: 5px">
        <div class="is-vertical-align is-horizontal-align" style="margin-top: 5px; height: 20vh; background-image: url('../Images/0.jpg'); background-position: center; background-size: cover;">
        <h1 class="text-uppercase" style="background-color: rgba(160, 160, 160, 0.64); padding: 5px; color: white"><?php echo $idea["TITLE"] ?></h1>
        </div>
        <div>
            <div class="row" style="margin-top: 5px">
                <div class="col-8">
                    <p><img src="<?php echo $idea["PICTURE"] ?>" alt="l'image n'à pas pu être affichée"></p>
                    <h3>Description</h3>
                    <?php echo $idea["DESCRIPTION"] ?>
                </div>
                <div class="col-4">
                    <div class="card">
                        <h3>Organisateur : <?php echo $data["USER"]["USERNAME"] ?></h3>
                        <progress value="<?php echo $idea["TOTAL_POINTS"] ?>" max="<?php echo $idea["GOAL"] ?>"></progress>
                        <p><?php echo $idea["TOTAL_POINTS"] ?> sur <?php echo $idea["GOAL"]?> pts</p>
                        <form action="?controller=Admin&action=deleteIdea" method="post">
                            <input type="hidden" name="ideaID" value="<?php echo $idea["IDEA_ID"] ?>">
                            <input type="submit" value="supprimer idée">
                        </form>
                    </div>
                    <?php
                    if (isset($data["CONTENTS"])) {
                        foreach($data["CONTENTS"] as $content) {
                            ?>
                            <div class="card" style="margin-top: 5px">
                                <h4> <?php echo $content["TITLE"] ?> </h4>
                                <code> <?php if ($content["POINTS"] < $idea["TOTAL_POINTS"]) echo 'Atteint'; else echo $content["POINTS"]; ?> </code>
                                <p><?php echo $content["DESCRIPTION"] ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="is_vertical_align" style="margin-top: 5px">
                <h1 class="text-uppercase" style="background-color: rgba(160, 160, 160, 0.64); padding: 5px; color: white">Commentaires</h1>
                <?php
                foreach ($comments as $comment) { ?>
                    <div style="margin: 15px" class="card">
                        <p><?php echo $comment["USERNAME"] ?></p>
                        <p><?php echo $comment["comment"]?></p>
                        <form action="?controller=Admin&action=deleteComment" method="post">
                            <input type="hidden" name="ideaid" value="<?php echo $idea["IDEA_ID"] ?>">
                            <input type="hidden" name="commentid" value="<?php echo $comment["comment_id"] ?>">
                            <input type="hidden" name="userid" value="<?php echo $comment["user_id"] ?>">
                            <input type="submit" value="supprimer">
                        </form>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php
end_page();
?>