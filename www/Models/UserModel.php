<?php

class UserModel extends AbstractModel
{
    private int $userID;
    private string $username;
    private string $password;
    private string $role;
    private string $email;
    private int $points;

    public static function fetchPoints(string $username) : array
    {
        $result = database::executeQuery("SELECT POINTS FROM USER WHERE USERNAME ='$username'");
        return empty($result) ? array() : $result[0];
    }

    function getAllUsers()
    {
        $query = database::executeQuery('SELECT * FROM USER;');
        $userList = NAN;

        foreach ($query as $user)
        {
            $userList[] = new User($user['USER_ID'],
                $user['USERNAME'],
                $user['PASSWORD'],
                $user['ROLE'],
                $user['AVAILABLE_POINTS'],
                $user['EMAIL']);
        }
        return $userList;
    }

    static function updatePassword($password)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        Database::executeUpdate("UPDATE USER SET PASSWORD = '$hashPassword' WHERE PASSWORD = '$password';");
    }

    public static function createWaitingUser(UserModel $user): bool
    {
        return Database::executeUpdate("INSERT INTO `user_waiting`(USERNAME, EMAIL, ROLE) VALUES ('" . $user->getUserName() . "', '" . $user->getEmail(). "', '" . $user->getRole(). "');");
    }

    /**
     * Returns a list of all users
     * @return array
     * @throws Exception
     */
    public static function fetchAll() : array {
        return Database::executeQuery("SELECT USER_ID AS USERID, USERNAME, PASSWORD, ROLE, EMAIL, POINTS FROM USER");
    }

    public static function fetchAllWaiting(): array {
        return Database::executeQuery("SELECT USER_ID AS USERID, EMAIL, USERNAME, ROLE FROM USER_WAITING");
    }

    public static function createUser(UserModel $user) : bool
    {
        return Database::executeUpdate("
            INSERT INTO 
                `user` (USERNAME, PASSWORD)
            VALUES( '" . $user->getUserName() . "',
            '" . $user->getPassword() . "'
        );");
    }

    /**
     * @throws Exception
     */
    function getUserWithId($id): User
    {
        $query = database::executeQuery("SELECT * FROM USER WHERE USER_ID='$id';")[0];
        $user = new User($query['USER_ID'],
            $query['USERNAME'],
            $query['PASSWORD'],
            $query['ROLE'],
            $query['AVAILABLE_POINTS'],
            $query['EMAIL']);
        return $user;
    }

    function getUserByUsername ($username): User
    {
        $query = database::executeQuery("SELECT * FROM USER WHERE USERNAME = '$username' ;")[0];
        $user = new User($query['USER_ID'],
            $query['USERNAME'],
            $query['PASSWORD'],
            $query['ROLE'],
            $query['AVAILABLE_POINTS'],
            $query['EMAIL']);
        return $user;

    }
    /**
     * @throws Exception
     */
    public static function deleteWaitingUser(int $userID): bool
    {
        return Database::executeUpdate("
            DELETE FROM user_waiting
            WHERE USER_ID = $userID;
        ");
    }

    /**
     * @throws Exception
     */
    public static function deleteUser(int $userID): bool
    {
        return Database::executeUpdate("
            DELETE FROM user
            WHERE USER_ID = $userID;
        ");
    }
    /**
     * @throws Exception
     */
    static function fetchId($username) : string
    {
        $query = database::executeQuery("SELECT USER_ID FROM USER WHERE USERNAME ='$username'")[0];
        return $query['USER_ID'];
    }

    /**
     * @throws Exception
     */
    public static function fetchRole(string $username) : string
    {
        $query = database::executeQuery("SELECT ROLE FROM USER WHERE USERNAME ='$username'")[0];
        return $query['ROLE'];
    }

    static function getEmailAdmin(): string
    {
        $query = database::executeQuery("SELECT EMAIL FROM USER WHERE ROLE='ADMIN';")[0];
        return $query['EMAIL'];
    }

    static function getEmailUser($username): string
    {
        $query = database::executeQuery("SELECT EMAIL FROM USER WHERE USER='$username';")[0];
        return $query['EMAIL'];
    }

    static function fetchPassword($password) : bool
    {
        $user_id = $_SESSION['id'];
        return Database::executeCount("SELECT COUNT(*) FROM USER WHERE PASSWORD='$password' AND USER_ID = '$user_id';") >1;
    }

    static  function updatePoint($point)
    {
        Database::executeUpdate("UPDATE USER SET POINTS =$point WHERE ROLE = 'jury';");
    }
    static  function removePoint()
    {
        $userID = $_SESSION['id'];
        Database::executeUpdate("UPDATE USER SET POINTS = POINTS - 1 WHERE USER_ID = '$userID'");
    }

    static function fetchPoint()
    {
        $userID = $_SESSION['id'];
        return Database::executeQuery("SELECT POINTS FROM USER WHERE USER_ID = '$userID'")[0]['POINTS'];
    }

    static function countJury(){

        return Database::executeCount("SELECT COUNT(*) FROM USER WHERE ROLE = 'jury';");

    }

    /**
     * @deprecated
     * @param $username
     * @return bool
     */
    function isLogin ($username): bool
    {
        return database::executeCount("SELECT COUNT(*) FROM USER WHERE USERNAME = '$username';") >= 1;
    }

    public static function fetchUser($userID){
        return database::executeQuery("SELECT * FROM USER WHERE USER_ID = $userID")[0];
    }

    /**
     * @param UserModel $user
     * @return bool
     * @throws Exception
     */
    public static function updateUser(UserModel $user) : bool {
        if ($user->getPassword() !== '') {
            $user->setPassword(password_hash($user->getPassword(),PASSWORD_DEFAULT));
        }
        return Database::executeUpdate("
            UPDATE 
                `user`
            SET
                USERNAME = '$user->username',
                PASSWORD = '$user->password',
                EMAIL = '$user->email',
                ROLE = '$user->role'
            WHERE
                USER_ID = '$user->userID';
        ");
    }

    public static function usernameAlreadyExists(int $userID, string $username) : bool {
        return Database::executeCount(
            "SELECT COUNT(*)
                    FROM `user` 
                    WHERE USER_ID != '$userID' 
                        AND USERNAME = '$username'") > 0;
    }

    /**
     * @param $username
     * @return bool
     */
    public static function userNameExists($username): bool
    {
        return database::executeCount("SELECT COUNT(*) FROM USER WHERE USERNAME = '$username';") > 0;
    }

    function isPassword ($username, $password): bool
    {
        return password_verify($password, database::executeQuery("SELECT PASSWORD FROM USER WHERE USERNAME='$username';")[0]["PASSWORD"]);
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @param int $userID
     */
    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public static function getAllEmails() : array {
        return Database::executeQuery("SELECT * FROM USER_WAITING;");
    }
}