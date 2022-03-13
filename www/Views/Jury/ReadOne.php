<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page('test');
/** @var array $data */
if (isset($data['IDEA'])){
    $idea = $data['IDEA']['IDEA'];
}
if(isset($data['USER'])){
    $user=$data['USER'];
}
if (isset($data['COMMENTS'])){
    $comments = $data['COMMENTS'];
}
if (isset($data['CONTENTS'])){
    $users = $data['CONTENTS'];
}
if(isset($data['ERROR'])){
    $errorVote = $data['ERROR'];
}
if(isset($data['CAMPAIGN']))
{
    $campaing = $data['CAMPAIGN'];
}
navbar();
if(!empty($data['IDEA']))
{
    ?>
    <div class="container" style="margin-top: 5px">
        <div class="container"">
            <h1 class="text-uppercase text-center"><?php echo $idea['TITLE'] ?></h1>
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
                        <h3>Organisateur : <?php echo $data['IDEA']['USER']['USERNAME'] ?></h3>
                    </div>

                    <div class="card" style="margin-top: 5px">
                        <?php if( (int)$idea['REALISED'] === 0){?>
                            <form action="?controller=Jury&action=juryVote" method="post">
                                <input type="hidden" name="ideaID" value="<?php echo $idea['IDEA_ID']?>">
                                <input type="submit" value="Vote">
                            </form>
                        <?php } else {?>
                            <div>
                                <p>Cette idée a déjà été validé</p>
                            </div>
                        <?php }?>
                    </div>

                    <?php
                    if (isset($data['CONTENTS'])) {
                        foreach($data['CONTENTS'] as $content) {
                            ?>
                            <div class="card" style="margin-top: 5px">
                                <h4> <?php echo $content['TITLE'] ?> </h4>
                                <code> <?php if ($content['POINTS'] < $idea['TOTAL_POINTS']) echo 'Atteint'; else echo $content['POINTS']; ?> </code>
                                <p><?php echo $content['DESCRIPTION'] ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="is_vertical_align" style="margin-top: 5px">
                <h1 class="text-uppercase">Commentaires</h1>
                <?php
                if(!empty($comments)){
                    foreach ($comments as $comment) { ?>
                        <div style="margin: 15px" class="card">
                            <p><?php echo $comment["USERNAME"] ?></p>
                            <p><?php echo $comment["comment"]?></p>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
else{?>
    <h3>aie, pas d'idées</h3>
    <?php
}
end_page();
?>