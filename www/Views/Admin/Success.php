<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
start_page("test");
navbar();
/** @var array $data */
?>
    <h1>Opération réussie</h1>
<?php
returnButton($data['path']);
end_page();