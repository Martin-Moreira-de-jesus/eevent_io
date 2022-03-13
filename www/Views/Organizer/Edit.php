<?php
start_page("OrgaView");
navbar();
/** @var array $data */
$idea = $data['idea'];
$content = $data['content'];
?>
<div class="container" style="margin-top: 5px">
    <?php if ($idea["TOTAL_POINTS"] == 0) { ?>
    <form enctype="multipart/form-data" action="/?controller=Idea&action=editIdea" method="post">
        <input name="id" type="hidden" value="<?php echo $idea["IDEA_ID"] ?>" required>
        <table class="bd-grey striped">
            <caption><h2>Modifier mon idée</h2></caption>
            <thead>
            <tr>
                <th>Champ</th>
                <th>Valeur du champ</th>
            </tr>
            </thead>
            <tr>
                <td><label for="title">Titre</label></td>
                <td><input type="text" name="title" value="<?php echo $idea["TITLE"] ?>" required></td>
            </tr>
            <tr>
                <td><label for="description">Description</label></td>
                <td><textarea name="description" required><?php echo $idea["DESCRIPTION"] ?></textarea></td>
            </tr>
            <tr>
                <td><label for="goal">Goal</label></td>
                <td><input type="number" name="goal" value="<?php echo $idea["GOAL"] ?>" required min="<?php echo $idea["GOAL"]?>"></td>
            </tr>
            <tr>
                <td><label for="image">Picture</label></td>
                <td>
                    <img src="<?php echo $idea["PICTURE"] ?>" style="max-height: 30vh; max-width: 50vw;">
                    <input type="file" name="image" accept="image/*">
                </td>
            </tr>
        </table>
        <input type="submit" value="Enregistrer" style="margin-top: 5px">
    </form>
    <?php } else { ?>
    <h3 class="text-center">Votre idée à reçu des votes, vous ne pouvez plus la modifier</h3>
    <?php } ?>
    <table class="bd-grey striped">
        <caption><h3>Liste des buts</h3></caption>
        <thead>
        <tr>
            <td>Nom du But</td>
            <td>Description</td>
            <td>Valeur du But</td>
            <td>Supprimer</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($content as $CONTENT) {
            ?>
            <tr>
                <td><?php echo $CONTENT['TITLE'] ?></td>
                <td><?php echo $CONTENT['DESCRIPTION'] ?></td>
                <td><?php echo $CONTENT['POINTS'] ?></td>
                <td>
                    <form action="/organisateur/modifier/<?php echo $idea["IDEA_ID"] ?>?controller=Organizer&action=deleteContent" method="post">
                        <input type="hidden" name="iid" value="<?php echo $idea['IDEA_ID'] ?>">
                        <input type="hidden" name="title" value="<?php echo $CONTENT['TITLE'] ?>">
                        <?php if ($idea["TOTAL_POINTS"] >= $CONTENT["POINTS"]) { ?>
                        <p class="button error">But atteint</p>
                        <?php } else  { ?>
                        <input type="submit" value="Supprimmer">
                        <?php } ?>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <form style="margin-top: 20px" class="bd-grey" action="/organisateur/modifier/<?php echo $idea["IDEA_ID"] ?>?controller=Organizer&action=addContent" method="post">
        <div class="card" style="margin-top: 20px">
            <h3>Ajouter un but.</h3>
            <input type="hidden" name="iid" value="<?php echo $idea['IDEA_ID'] ?>" required>
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>
            <label for="goal">But</label>
            <input id="goal" type="number" name="goal" required min="<?php echo $idea["GOAL"] >= $idea["TOTAL_POINTS"] ? $idea["GOAL"] + 1 : $idea["TOTAL_POINTS"] + 1; ?>">
            <input type="submit" name="Ajouter" style="margin-top: 5px">
        </div>
    </form>
</div>
<?php
end_page();
?>
