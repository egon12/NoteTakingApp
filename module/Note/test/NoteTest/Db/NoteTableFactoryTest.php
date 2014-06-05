<?php
/**
 * NoteTableFactory
 * 
 * 
 * 
 * PHP Version 5.5
 * 
 * @category Model
 * @package  Business
 * @author   Egon Firman <egon.firman@gmail.com>
 * @license  http://bvap.me None
 * @link     http://bvap.me
 **/
 
namespace NoteTest\Db;

use Note\Db\NoteTableFactory;
use NoteTest\Bootstrap;
use Zend\Db\Ddl\CreateTable;

class NoteTableFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $sm = Bootstrap::getServiceManager();
        $this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
    }

    public function testCreate()
    {
        $sql = "CREATE TABLE \"notetemp\" (\n    \"id\" INTEGER NOT NULL AUTO_INCREMENT,\n"
            . "    \"note_id\" CHAR(13)  ,\n    \"title\" VARCHAR(512)  ,\n    \"body\" TEXT  ,"
            . "\n    \"timetamp\" DATE NOT NULL \n)";
        $this->assertSame($sql, NoteTableFactory::createTable($this->adapter));
    }
}
