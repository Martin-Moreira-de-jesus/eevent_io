<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';
start_page("test");
navbar();
?>
    <div class="container" style="margin-top: 5px">
        <div class="card">
            <h2>Campagne en Cours</h2>
            <table class="bd-grey striped">
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
            </table>
        </div>
        <div class="card" style="margin-top: 5px">
            <h2>Campagne du XX au XX</h2>
            <table class="bd-grey striped">
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
            </table>
        </div>
        <div class="card" style="margin-top: 5px">
            <h2>Campagne du XX au XX</h2>
            <table class="bd-grey striped">
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
                <tr>
                    <td>Table Cell 1</td>
                    <td>Table Cell 2</td>
                </tr>
            </table>
        </div>
    </div>
<?php
end_page();
?>