<?php
start_page("test");

/** @var array $data */
//$status = $data["STATUS"];
$status = $data["STATUS"];
$idea = $data["IDEA"];
if (isset($data["COMMENTS"])) {
    $comments = $data["COMMENTS"];
}
if (isset($data["CONTENTS"])) {
    $contents = $data["CONTENTS"];
}
navbar();?>
    <div class="container" style="margin-top: 5px">
        <div class="container" style="margin-top: 5px; height: 20vh; background-image: url('../Images/0.jpg'); background-position: center; background-size: cover;">
            <h1 class="text-center text-uppercase"><?php echo $idea["TITLE"]?> </h1>
            <?php if ($status === 'deliberation') { ?>
            <p class="text-center">Cette idée est courrament en délibération</p>
            <?php } else if ($status === 'over') { ?>
            <p>Cette idée appartient à une campagne terminée</p>
            <?php } ?>
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
                        <h3>Organisateur : <?php echo $data["USER"]["USERNAME"] ?></h3>
                        <progress value="<?php echo $idea["TOTAL_POINTS"] ?>" max="<?php echo $idea["GOAL"] ?>"></progress>
                        <p><?php echo $idea["TOTAL_POINTS"] ?> sur <?php echo $idea["GOAL"]?> pts</p>
                    </div>
                    <?php if ((isset ($_SESSION['role']) && $_SESSION['role'] === DONOR && $status === 'running')) { ?>
                        <div class="card" style="margin-top: 5px">
                            <form action="?controller=Donator&action=userVote" method="post">
                                <label>
                                    <input type="hidden" name="ideaID" value="<?php echo $idea["IDEA_ID"] ?>">
                                </label>
                                <label>
                                    <input min="0"  name="pts" type="number">
                                </label>
                                <input type="submit" value="Donner">
                            </form>
                        </div>
                    <?php }
                    if (isset($contents)) {
                        foreach($contents as $content) {
                            ?>
                            <div class="card" style="margin-top: 5px">
                                <h4> <?php echo $content["TITLE"] ?> </h4>
                                <code> <?php if ($content["POINTS"] < $idea["TOTAL_POINTS"]) echo 'Atteint'; else echo'Objectif : ' . $content["POINTS"]; ?> </code>
                                <progress value="<?php echo $idea["TOTAL_POINTS"] ?>" max="<?php echo $content["POINTS"] ?>"></progress>
                                <p><?php echo $content["DESCRIPTION"] ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
                <div class="is_vertical_align" style="margin-top: 5px">
                    <h1 class="text-uppercase">Commentaires</h1>
                    <?php if (isset ($_SESSION['role']) and $_SESSION['role'] === DONOR){ ?>
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
