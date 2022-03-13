<?php
start_page("test");
navbar();
/** @var array $data */
if(isset($loginError))
    $loginError = $data["loginError"];
?>
    <section>
        <div class="box">
            <div class="square" style="--i:0;"></div>
            <div class="square" style="--i:1;"></div>
            <div class="square" style="--i:2;"></div>
            <div class="square" style="--i:3;"></div>
            <div class="square" style="--i:4;"></div>
            <div class="container2">
                <div class="form">
                    <h2>Login</h2>
                    <form method="POST" action="?controller=User&action=login">
                        <?php if(!empty($loginError)){ echo $loginError; }?>
                        <div class="inputBox"   >
                            <input type="text" name="login" placeholder="Identifiant">
                        </div>
                        <div class="inputBox">
                            <input type="password" name="password" placeholder="Mot de Passe">
                        </div>
                        <div class="inputBox" >
                            <input  type="submit" name="submit" value="submit"></a>
                        </div>
                        <p class="forget">Faire une demande de création de compte : <a href="enregistrement">Clique ici</a> </p>
                        <p class="forget">Mot de passe oublié <a href="/recuperation">Clique Ici</a></p>
                    </form>
                    <a href="/">Retour à la page d'acceuil</a>
                </div>
            </div>
        </div>
    </section>
<?php
end_page();
?>