<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include_once $doc_root.'/../Utils/HelperUtils.php';
start_page("Créez votre Idée.");
navbar();
?>
<section>
    <div class="box">

        <div class="square" style="--i:0;"></div>
        <div class="square" style="--i:1;"></div>
        <div class="square" style="--i:2;"></div>
        <div class="square" style="--i:3;"></div>
        <div class="square" style="--i:4;"></div>

        <div class="container2">
            <form enctype="multipart/form-data" action="organisateur/creer?controller=Organizer&action=createIdea" method="post" style="margin: 20px">
                <h1>Votre Idée</h1>
                <div class="group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" required/>
                </div>
                <div class="group">
                    <label for="caption">Description</label>
                    <input type="text" id="caption" name="description" required>
                </div>
                <div class="group">
                    <label for="goal">Goal</label>
                    <input type="text" id="goal" name="goal" required min="500">
                </div>
                <div class="group file_area" style="margin-bottom: 5px">
                    <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                    <label for="image">Image</label>
                    <input type="file" name="image" accept="image/*" required/>
                </div>

                <div class="group">
                    <input type="submit" value="Enregister">
                </div>
            </form>
        </div>
    </div>
</section>

<?php
end_page();
?>
