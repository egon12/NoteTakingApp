<?php
/**
 * NoteTableGatewayTest
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

use NoteTest\Bootstrap;
use Note\Db\NoteTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;

class NoteTableTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $sm = Bootstrap::getServiceManager();
        $this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
    }

    public function testSchema()
    {
        $tableName = 'note';

        $table = new NoteTable($this->adapter);
        $this->assertSame($tableName, $table->getTable());

        $metadata = new Metadata($this->adapter);
        $columns = $metadata->getColumnNames($tableName);

        $needle = array('id', 'note_id', 'title', 'body', 'user_id', 'timestamp');

        sort($needle);
        sort($columns);

        $this->assertEquals($needle, $columns, 'Table "note" need to be checked');

        // try to catch error with this
        // $table->select();
    }

    public function testInsert()
    {
        // todo insert data and get newly data maybe like
        // todo create this in other database or maybe create mockup
        
        /*
        $arr = array (
            'head'  => 'Hello World!!',
            'body'  => 'Hello this is my world..',
            'created'  => date('Y-m-d H:i:s')
        );

        $this->noteTable->insert($arr);
        */
    }
}
