<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page("test");
navbar();
?>
<br>
<br>
<div class="text-center">
<h4 class="text-error"> Nous sommes désolé, soit il n'y a aucune campagne active actuellement,
    soit aucune idée d'évènement n'a encore été proposée. </h4>
</div>

