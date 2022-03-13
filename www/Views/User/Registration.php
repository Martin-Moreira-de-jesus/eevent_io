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
                <h2>Inscription</h2>
                <form method="post" action="?controller=User&action=askRegistration">
                    <label>Email</label>
                    <div class="inputBox">
                        <input type="email" name="email" placeholder="Votre email">
                    </div><br>
                    <label>Username</label>
                    <div class="inputBox">
                        <input type="text" name="username" placeholder="Votre Pseudo">
                    </div><br>
                    <label>Rôle souhaité (sous réserve de l'approbation de l'administrateur)</label>
                    <select name="role" id="role-select">
                        <option>Choisissez une option</option>
                        <option value="<?PHP echo ADMIN ?>"><?PHP echo ADMIN ?></option>
                        <option value="<?PHP echo JURY ?>"><?PHP echo JURY ?></option>
                        <option value="<?PHP echo DONOR ?>"><?PHP echo  DONOR ?></option>
                        <option value="<?PHP echo ORGANIZER ?>"><?PHP echo ORGANIZER ?></option>
                        <option value="<?PHP echo _PUBLIC ?>"><?PHP echo _PUBLIC ?></option>
                    </select>
                    <br>
                    <div class="inputBox">
                        <input type="submit" value="Envoyer">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
end_page();
?>
