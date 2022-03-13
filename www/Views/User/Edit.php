<?php
$doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
include substr($doc_root, 0, -6).'/Utils/AutoLoader.php';start_page("test");
navbar();

/** @var array $data */
$user = $data[0];
?>
    <div class="container" style="margin-top: 5px">
        <h1 class="text-center"> Utilisateur : </h1>
        <tr>
            <td><?php echo $user["USER_ID"] ?></td>
            <td><?php echo $user["USERNAME"]?></td>
            <td><?php echo $user["PASSWORD"]?></td>
            <td><?php echo $user["ROLE"]?></td>
        </tr>
        <h1 class="text-center"> Modifier : </h1>
        <form action="../../Scripts/EditUser.php?id=<?php echo $user["USER_ID"]?>" method="post" name="user_id">
            <div class="inputBox">
                <label>
                    <p>User Id : </p>
                </label>
                <label>
                    <input name="username" type="text" placeholder="Nouveau nom d'utilisateur">
                </label>
            </div>
            <div class="inputBox">
                <label>
                    <input name="password" type="password" placeholder="Nouveau mot de passe">
                </label>
            </div>
            <label for="role-select"></label>
            <select name="role" id="role-select">
                <option value="">Choisissez une option</option>
                <option value="admin">Admin</option>
                <option value="event">Proposeur d'event</option>
                <option value="jury">Jury</option>
                <option value="voter">Voteur</option>
            </select>
            <input type="submit" class="square">
        </form>
    </div>
<?php
end_page();
?>