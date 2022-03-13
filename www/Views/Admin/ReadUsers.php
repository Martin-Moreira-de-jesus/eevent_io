<?php
start_page("test");
navbar();
returnButton('.');
/** @var array $data */
$users = $data['users'];
for ($i = 0, $max = count($users); $i < $max; ++$i) {
    $users[$i] = UserModel::constructFromArray($users[$i]);
}
if (isset($data['errors'])) {
    displayErrors($data['errors']);
}
$emails = $data['emails'];
/** @var UserModel $user */
?>
    <div class="container" style="margin-top: 5px">
        <a href="?controller=Admin&action=createUser" class="button error">Ajouter Utilisateur</a>
        <a href="?controller=Admin&action=seeWaitingUser" class="button error">Examiner demandes</a>
        <h1 class="text-center"> Listes des utilisateurs </h1>
            <div class="row is-center" class="striped">
                <?php foreach ($users as $user) { ?><br>
                <form style="padding: 1em" class="row is-center" class="row" method="post" action="?controller=Admin&action=editUser">
                    <input type="hidden" name="userid" value="<?php echo $user->getUserID() ?>">
                    <label class="text-center" for="username_input"><strong>Nom d'utilisateur actuel : <?php echo $user->getUsername() ?></strong></label>
                    <input class="bd-dark text-center" type="text" id="username_input" name="username" value="<?php echo $user->getUsername() ?>"
                    placeholder="<?php echo $user->getUsername() ?>">
                    <label for="password_input"><strong>Changer le mot de passe :</strong></label>
                    <input class="bd-dark text-center" type="text" id="password_input" name="password">
                    <label for="role-select"><strong>Role actuel : <?php echo $user->getRole() ?></strong></label>
                    <select class="bd-dark text-center" name="role" id="role-select">
                        <option value="<?php echo $user->getRole() ?>">Choisissez une option</option>
                        <option value="<?PHP echo ADMIN ?>"><?PHP echo ADMIN ?></option>
                        <option value="<?PHP echo JURY ?>"><?PHP echo JURY ?></option>
                        <option value="<?PHP echo DONOR ?>"><?PHP echo DONOR ?></option>
                        <option value="<?PHP echo ORGANIZER ?>"><?PHP echo ORGANIZER ?></option>
                        <option value="<?PHP echo _PUBLIC ?>"><?PHP echo _PUBLIC ?></option>
                    </select>
                    <?php if ($user->getEmail() !== 'none') { ?><br>
                        <label class="col is-center"><strong>Email actuel : <?php echo trim($user->getEmail())?></strong></label>
                    <?php } ?>
<input class="col-12 row is-center" style="margin: 1em" value="Modifier" type="submit">
                </form>
                <?php } ?>
</div>

    </div>
<?php
end_page();
?>