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
        <h1 class="text-center"> Listes des demandes de création de compte </h1>
        <div class="striped">
            <?php foreach ($users as $user) { ?><br>
                <form style="padding: 15px" class="bd-grey" method="post" action="?controller=Admin&action=createUserFromWaitingUser">
                    <label for="username_input">Nom d'utilisateur souhaité : <?php echo $user->getUsername() ?></label>
                    <input type="text" id="username_input" name="username" value="<?php echo $user->getUsername() ?>"
                           placeholder="<?php echo $user->getUsername() ?>">
                    <label for="password_input"> Lui attribuer un mot de passe (ou laisser celui attribué automatiquement): </label>
                    <input type="text" id="password_input" name="password" value="<?php $controller = new AdminController(); echo $controller->randomPassword();?>"
                    placeholder="<?php $controller = new AdminController(); echo $controller->randomPassword();?>">
                    <label for="role-select">Role désiré: <?php echo $user->getRole() ?></label>
                    <select name="role" id="role-select" value="">
                        <option value="<?php echo $user->getRole() ?>">Choisissez une option</option>
                        <option value="<?PHP echo ADMIN ?>"><?PHP echo ADMIN ?></option>
                        <option value="<?PHP echo JURY ?>"><?PHP echo JURY ?></option>
                        <option value="<?PHP echo DONOR ?>"><?PHP echo DONOR ?></option>
                        <option value="<?PHP echo ORGANIZER ?>"><?PHP echo ORGANIZER ?></option>
                        <option value="<?PHP echo _PUBLIC ?>"><?PHP echo _PUBLIC ?></option>
                    </select>
                        <label>Email actuel : <?php echo $user->getEmail() ?></label>
                    <input type="hidden" name="email" value="<?php echo $user->getEmail() ?>">
                    <input type="hidden" name="userID" value="<?php echo $user->getUserID() ?>">
                    <input value="Créer utilisateur" type="submit" class="square">
                </form>
            <?php } ?>
        </div>
    </div>
<?php
end_page();
?>