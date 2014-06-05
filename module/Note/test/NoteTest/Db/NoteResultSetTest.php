<?php
/**
 * NoteResultSetTest
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

use Note\Db\NoteResultSet;

class NoteResultSetTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $resultSet = new NoteResultSet();
        $this->assertInstanceOf('Note\Entity\NoteEntity', $resultSet->getArrayObjectPrototype());
    }
}
