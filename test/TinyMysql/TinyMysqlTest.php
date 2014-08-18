<?php
/**
 * TinyMysql.php
 * 
 * @package
 * @author    gong023 <gon.gong.gone@gmail.com>
 */
namespace TinyMysql;

/**
 * Class LibName
 *
 * @package TinyMysql
 * @author  gong023 <gon.gong.gone@gmail.com>
 */
class TinyMysqlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \TinyMysql\TinyMysqlConnectionError
     */
    public function connectionError()
    {
        TinyMysql::execute(
            'show create table table;',
            'localhost',
            'root',
            'invalid password',
            'database',
            '3306',
            '/tmp/mysql.sock'
        );
    }
}
