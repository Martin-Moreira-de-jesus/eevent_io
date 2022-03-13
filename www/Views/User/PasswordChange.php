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
                    <h2>Changer le mot de passe</h2>
                    <form action="?controller=User&action=changePassword" method="post">
                        <label>Ancien Mot de passe</label>
                        <div class="inputBox">
                            <input type="password" name="oldPassword" placeholder="Ancien mot de passe">
                        </div><br>
                        <label>Votre nouveau mot de passe</label>
                        <div class="inputBox">
                            <input type="password" name="newPassword" placeholder="Nouveau mot de passe">
                        </div><br>
                        <?php ?>
                        <label>Confirmation du mot de passe</label>
                        <div class="inputBox">
                            <input type="password" name="confirmPassword" placeholder="Confirmation du mot de passe">
                        </div>
                        <div class="inputBox">
                            <input type="submit" value="Change">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php
end_page();
?>