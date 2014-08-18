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
     * @var TinyMysql
     */
    private static $instance = null;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $database;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $socket;

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
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        $this->port = $port;
        $this->socket = $socket;
    }

    /**
     * @param $rowQuery
     * @throws TinyMysqlConnectionError
     * @throws TinyMysqlExecuteError
     * @return bool|\mysqli_result
     */
    public function query($rowQuery)
    {
        try {
            $connection = new \mysqli($this->host, $this->user, $this->pass, $this->database, $this->port, $this->socket);
        } catch (\Exception $e) {
            // http://php.net/manual/ja/mysqli.construct.php とかのサンプルコードだとエラー拾えない
            throw new TinyMysqlConnectionError($e->getMessage());
        }

        $query = $connection->real_escape_string($rowQuery);
        $result = $connection->query($query);
        $connection->close();
        self::$instance = null;
        if (! $result) {
            throw new TinyMysqlExecuteError($connection->error);
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
    public static function getInstance($host, $user, $pass, $database, $port, $socket)
    {
        if (is_null(self::$instance)) {
            return new self($host, $user, $pass, $database, $port, $socket);
        }

        return self::$instance;
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
    public static function execute($rowQuery, $host, $user, $pass, $database, $port, $socket) {
        $instance = self::getInstance($host, $user, $pass, $database, $port, $socket);

        return $instance->query($rowQuery);
    }
}
