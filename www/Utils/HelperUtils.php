<?php
function displayErrors(array $errors) {
    foreach($errors as $error) {?>
        <p><?php echo $error ?></p>
<?php
    }
}
function start_page($title)
{
    echo '<!DOCTYPE html>'.PHP_EOL;
    echo '<html lang="fr">'.PHP_EOL;
    echo '<head>'.PHP_EOL;
    echo '    <meta charset="UTF-8">'.PHP_EOL;
    echo '    <link rel="stylesheet" href="https://unpkg.com/chota@latest">'.PHP_EOL;
    echo '    <link rel="stylesheet" href="/css/style.css" type="text/css" media="all">'.PHP_EOL;
    echo '    <title>'.$title.'</title>'.PHP_EOL;
    echo '</head>'.PHP_EOL;
    echo '<body style="min-height: 100vh">'.PHP_EOL;
}

function returnButton($path) {
    echo "  <a href=\"$path\">Retour</a>" . PHP_EOL;
}

function navbar()
{ ?>
    <nav class="nav">
        <div class="nav-left">
            <?php if (isset($_SESSION['role'])) {
                switch ($_SESSION['role'])  {
                    case 'admin':
                        echo '            <a class="active" href="/admin"><button class="button success">Mon Espace</button></a>' . PHP_EOL;
                        break;
                    case 'jury':
                        echo '            <a href="/jury"><button class="button success">Mon Espace</button></a>'.PHP_EOL;
                        break;
                    case 'organizer':
                        echo '            <a href="/organisateur"><button class="button success">Mon espace</button></a>'.PHP_EOL;
                        break;
                    case 'donor':
                        echo '      <h3>Points : ' . $_SESSION['points']["POINTS"] . '</h3>';
                        break;
                }
            } ?>
        </div>
        <div class="nav-center">
            <a href='/' class="brand">E-Event.io</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['id'])) {
                echo '              <a href="/changemdp"><button class="button error">Changer mdp</button></a>'.PHP_EOL;
                echo '              <a href="?controller=User&action=logout"><button class="button error">Logout</button></a>'.PHP_EOL;
            } else {
                echo '              <a class="button primary" href="/login">Login</a>' .PHP_EOL;
            }?>
        </div>
    </nav>
<?php
}

function end_page()
{
    echo '    <footer>'.PHP_EOL;
    echo '    </footer>'.PHP_EOL;
    echo '</body>'.PHP_EOL;
    echo '</html>'.PHP_EOL;
}
/*
 *

    echo '    <nav class="nav">'.PHP_EOL;

    echo '        <div class="nav-left tabs">'.PHP_EOL;

    if (isset ($_SESSION['role']) and $_SESSION['role'] === 'admin') {
        echo '              <a class="active" href="/admin"><button class="button success">Espace Administrateur</button></a>'.PHP_EOL;
    }
    if(isset ($_SESSION['role']) and $_SESSION['role'] ==='organizer'){
        echo '            <a href="/organisateur"><button class="button success">Espace Organisateur</button></a>'.PHP_EOL;
    }
    if(isset ($_SESSION['role']) and $_SESSION['role'] ==='jury'){
        echo '            <a href="/jury"><button class="button success">Espace Jury</button></a>'.PHP_EOL;
    }
    echo '        </div>'.PHP_EOL;
    echo '        <div class="nav-center is-center">'.PHP_EOL;
    echo '            <a class="text-center" href="/">E-Event.io</a>' .PHP_EOL;
    echo '        </div>'.PHP_EOL;
    echo '        <div class="nav-right">'.PHP_EOL;
    echo '        </div>'.PHP_EOL;
    echo '        <div class="nav-right">'.PHP_EOL;
    if(!empty($_SESSION)){
        echo '              <a href="?controller=User&action=logout"><button class="button error">Logout</button></a>'.PHP_EOL;
    }
    if(empty($_SESSION)){
        echo '              <a class="button primary" href="/login">Login</a>' .PHP_EOL;
    }
    echo '        </div>'.PHP_EOL;
    echo '    </nav>'.PHP_EOL;
 */