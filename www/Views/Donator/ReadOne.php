<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page("test");
/** @var array $data */
$idea = ($data['idea']['IDEA']);
if (isset($data['idea']["COMMENTS"])) {
    $comments = $data['idea']["COMMENTS"];
}
if (isset($data['idea']["CONTENTS"])) {
    $contents = $data['idea']["CONTENTS"];
}
if (isset($data['errors'])) {
    $errors = $data['errors'];
}
navbar();?>

    <div class="container" style="margin-top: 5px">
        <div class="is-vertical-align is-horizontal-align" style="margin-top: 5px; height: 20vh; background-image: url('../Images/0.jpg'); background-position: center; background-size: cover;">
            <h1 class="text-uppercase"><?php echo $idea["TITLE"]?> </h1>
        </div>

        <div>
            <div class="row" style="margin-top: 5px">
                <div class="col-8">
                    <div class="is-vertical-align is-horizontal-align"><img src="<?php echo $idea["PICTURE"] ?>" alt="l'image n'à pas pu être affichée"></div>
                    <h3>Description</h3>
                    <?php echo $idea["DESCRIPTION"] ?>
                </div>
                <div class="col-4">
                    <div class="card">
                        <h3>Organisateur : <?php echo $data['idea']["USER"]["USERNAME"] ?></h3>
                        <progress value="<?php echo $idea["TOTAL_POINTS"] ?>" max="<?php echo $idea["GOAL"] ?>"></progress>
                        <p><?php echo $idea["TOTAL_POINTS"] ?> sur <?php echo $idea["GOAL"]?> pts</p>
                    </div>
                    <?php if (isset ($_SESSION['role']) and $_SESSION['role'] === DONOR){ ?>
                    <div class="card" style="margin-top: 5px">
                        <form action="?controller=Donator&action=userVote" method="post">
                            <label>
                                <input type="hidden" name="ideaID" value="<?php echo $idea["IDEA_ID"] ?>">
                            </label>
                            <label>
                                <input min="0"  name="pts" type="number">
                            </label>
                            <input type="submit" value="Donner">
                            <?php
                             if (isset($errors['notenough'])) { ?>
                                 <div>
                                     <p><?php echo $errors ['notenough'] ?></p>
                                 <?php } ?>
                                </div>
                        </form>
                    </div>
                    <?php }
                    if (isset($contents)){
                        foreach($contents as $content) {
                            ?>
                            <div class="card" style="margin-top: 5px">
                                <h4> <?php echo $content["TITLE"] ?> </h4>
                                <code> <?php if ($content["POINTS"] < $idea["TOTAL_POINTS"]) echo 'Atteint'; else echo 'Objectif de : ' . $content["POINTS"]; ?> </code>
                                <progress value="<?php echo $idea["TOTAL_POINTS"] ?>" max="<?php echo $content["POINTS"] ?>"></progress>
                                <p><?php echo $content["DESCRIPTION"] ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <br>
            <br>
            <div class="is_vertical_align" style="margin-top: 5px">
                <h1 class="text-uppercase">Commentaires</h1>
                <?php if (isset ($_SESSION['role']) && $_SESSION['role'] === DONOR) { ?>
                <?php
                if (isset($errors['noComment'])) { ?>
                    <div>
                        <p><?php echo $errors['noComment'] ?></p>
                    </div>
                <?php } ?>
                <form action="?controller=Donator&action=userComment" method="post">
                    <label>
                        <input type="hidden" name="ideaID" value="<?php echo $idea["IDEA_ID"] ?>">
                    </label>
                    <label>
                        <input maxlength="250" name="comment" placeholder="Laissez un commentaire">
                    </label>
                    <input type="submit" class="square">
                </form>
                    <?php
                }
                foreach ($comments as $comment) { ?>
                <div style="margin: 15px" class="card">
                    <p><?php echo $comment["USERNAME"] ?></p>
                    <p><?php echo $comment["comment"]?></p>
                </div>
                <?php } ?>
            </div>

        </div>
    </div>
<?php
end_page();
?>