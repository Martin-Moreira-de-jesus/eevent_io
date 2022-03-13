<?php
/*
const DB_HOST = "ludan.ddns.net";
const DB_LOGIN = "PHP";
const DB_PASS = "Gca7gPeAU9bU";
const DB_NAME = "PHP";
*/
const DB_HOST = "localhost";
const DB_LOGIN = "admin";
const DB_PASS = "admin";
const DB_NAME = "eevent_io";

class Database
{
    private static $connection;

    /**
     * @throws Exception
     */
    public static function openConnection(): void
    {
        self::$connection = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASS)
        or throw new Exception('Erreur connexion au serveur : ' . mysqli_connect_error(), 1);
        mysqli_select_db(self::$connection, DB_NAME)
        or throw new Exception('Erreur connexion au serveur : ' . mysqli_connect_error(), 1);
    }

    // for inserting, updating and deleting
    /**
     * @throws Exception
     */
    public static function executeUpdate($query): bool
    {
        if (!self::$connection) {
            self::openConnection();
        }

        //var_dump(self::$connection);

        return mysqli_query(self::$connection, $query);
    }


    /**
     * @throws Exception
     */
    public static function executeCount($query): int
    {
        if (preg_match_all('/INSERT|UPDATE|DELETE/i', $query) > 0) {
            self::closeConnection();
            throw new \RuntimeException("For any modification of the base use database::mysqli_update");
        }

        if (!self::$connection) {
            self::openConnection();
        }

        $db_result = mysqli_query(self::$connection, $query);
        if (!$db_result) {
            self::closeConnection();
            throw new \RuntimeException('Something went wrong with query : ' . $query . PHP_EOL, 2);
        }

        return (int)mysqli_fetch_assoc($db_result)["COUNT(*)"];
    }


    // for any other query
    /**
     * @throws Exception
     */
    public static function executeQuery($query): array
    {
        if (preg_match_all('/INSERT|UPDATE|DELETE/i', $query) > 0) {
            self::closeConnection();
            throw new \RuntimeException("For any modification of the base use database::mysqli_update");
        }

        if (!self::$connection) {
            self::openConnection();
        }

        $db_result = mysqli_query(self::$connection, $query);
        if (!$db_result) {
            self::closeConnection();
            throw new \RuntimeException('Something went wrong with query : ' . $query . PHP_EOL, 2);
        }

        $obj_array = array();

        while ($row = mysqli_fetch_assoc($db_result)) {
            $obj_array[] = $row;
        }

        return $obj_array;
    }

    /**
     * @throws Exception
     */
    public static function closeConnection(): void
    {
        if (!self::$connection) {
            self::openConnection();
        }

        mysqli_close(self::$connection);
    }
}