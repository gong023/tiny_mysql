<?php
/**
 * TinyMysql.php
 *
 * @package
 * @author    gong023 <gon.gong.gone@gmail.com>
 */
namespace TinyMysql;

/**
 * Class TinyMysql
 *
 * @package TinyMysql
 * @author  gong023 <gon.gong.gone@gmail.com>
 */
class TinyMysql
{
    /**
     * @var \mysqli|null
     */
    private static $connection = null;

    /**
     * ここprivateにしたいしmysqli継承できない
     *
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $database
     * @param int $port
     * @param string $socket
     * @throws TinyMysqlConnectionError
     */
    private function __construct($host, $user, $pass, $database, $port, $socket) {
        try {
            self::$connection = new \mysqli($host, $user, $pass, $database, $port, $socket);
        } catch (\Exception $e) {
            // http://php.net/manual/ja/mysqli.construct.php とかのサンプルコードだとエラー拾えない
            throw new TinyMysqlConnectionError($e->getMessage());
        }
    }

    /**
     * @param $rowQuery
     * @throws TinyMysqlExecuteError
     * @throws TinyMysqlEmptyConnectionError
     * @return bool|\mysqli_result
     */
    public function query($rowQuery)
    {
        if (is_null(self::$connection)) {
            throw new TinyMysqlEmptyConnectionError();
        }
        $query = self::$connection->real_escape_string($rowQuery);
        $result = self::$connection->query($query);
        self::$connection->close();
        self::$connection = null;
        if (! $result) {
            throw new TinyMysqlExecuteError('Execute Error :' . self::$connection->error);
        }

        return $result;
    }

    /**
     * @param $host
     * @param $user
     * @param $pass
     * @param $database
     * @param $port
     * @param $socket
     * @return \mysqli|null|TinyMysql
     */
    public static function getConnection($host, $user, $pass, $database, $port, $socket)
    {
        if (is_null(self::$connection)) {
            return new self($host, $user, $pass, $database, $port, $socket);
        }

        return self::$connection;
    }

    /**
     * @param $rowQuery
     * @param $database
     * @param $host
     * @param $user
     * @param $pass
     * @param $port
     * @param $socket
     * @return bool|\mysqli_result
     */
    public static function execute(
        $rowQuery,
        $host,
        $user,
        $pass,
        $database,
        $port,
        $socket
    ) {
        $instance = self::getConnection($host, $user, $pass, $database, $port, $socket);

        return $instance->query($rowQuery);
    }
}
