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
     */
    public function first()
    {
        $this->assertTrue(TinyMysql::execute());
    }
}
