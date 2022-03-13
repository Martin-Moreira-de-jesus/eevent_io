<?php
start_page("test");
navbar();
returnButton('.');
if (isset($data['errors'])) {
    displayErrors($data['errors']);
}
?>
    <div class="container" style="margin-top: 5px">
        <h1 class="text-center"> Créer une nouvelle campagne </h1>
            <div class="bd-grey" style="padding: 20px">
                <form action="?controller=Admin&action=createCampaign" method="post">
                    <label>Entrer le titre de la campagne :
                        <input type="text" name="Title" id "title" maxlength="25" placeholder="Entrez le nom de votre
                        nouvelle campagne" required>
                    </label>
                    <label> Sélectionner le début de la campagne :
                        <input type="date" name="BegDate" min="<?php echo date('Y-m-d') ?>" required>
                    </label>
                    <label>Sélectionner la fin de la campagne :
                        <input type="date" name="EndDate" min="<?php echo date('Y-m-d') ?>" required>
                    </label>
                    <label>Sélectionner la fin des délibérations :
                        <input type="date" name="DelibEndDate" min="<?php echo date('Y-m-d') ?>" required>
                    </label>
                    <label>Sélectionner le nombre de points à attribuer aux donateurs :
                        <input type="number" name="pts" min="1" required>
                    </label>
                    <a class="is-center" style="margin-top: 10px"><input type="submit" value="Enregistrer"></a>
                </form>
            </div>
    </div>