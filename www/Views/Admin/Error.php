<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page("test");
navbar();
returnButton('.');
if (isset($data['errors'])) {
    displayErrors($data['errors']);
}
?>
    <h1>Opération réussie</h1>
    <a href=".">Retour</a>
<?php
end_page();