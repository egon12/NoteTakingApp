<?php
/**
 * NoteCollectionTest
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
 
namespace NoteTest\Collection;

use Note\Collection\NoteCollection;
use Note\Db\NoteTable;
use Note\Db\NoteResultSet;
use Note\Entity\NoteEntity;
use NoteTest\Bootstrap;
use NoteTest\Entity\NoteEntityTest;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class NoteCollectionTest extends \PHPUnit_Framework_TestCase
{

    protected $createProvider;

    public function setUp()
    {
        $sm = Bootstrap::getServiceManager();
        $this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $table = new NoteTable($this->adapter);
        $this->noteCollection = new NoteCollection($table);

        $this->noteEntityCreateProvider();
    }

    public function testFetch()
    {
        $start = 0;
        $limit = 10;

        $this->noteCollection->setLimit($limit);

        $resultSet = $this->noteCollection->fetch($start);
        $this->assertInstanceOf('Note\Db\NoteResultSet', $resultSet);

        // without offset
        $resultSet = $this->noteCollection->fetch();
        $this->assertInstanceOf('Note\Db\NoteResultSet', $resultSet);
    }

    public function testCreate()
    {
        $note = new NoteEntity();

        $this->assertInstanceOf('Note\Entity\NoteEntity', $note);

        $note->setTitle($this->createProvider[0]['title']);
        $note->setBody($this->createProvider[0]['body']);

        $tableMock = $this->getMock('Note\Db\NoteTable', array(), array($this->adapter), '', false);
        $tableMock->expects($this->once())
            ->method('insert')
            ->with(
                $this->callback(array($this, 'tableMockCallbackOnCreate'))
            );

        // todo manipulate database ini here
        $this->noteCollection->setTable($tableMock)->create($note);
    }

    public function tableMockCallbackOnCreate($array)
    {
        $this->assertArrayHasKey('note_id', $array);
        $this->assertEquals($this->createProvider[0]['title'], $array['title']);
        $this->assertEquals($this->createProvider[0]['body'], $array['body']);
        return $array['note_id'];
    }

    public function testGet()
    {
        // prepraring note entity
        $note_id = '39283so4js0';
        $noteArray = array(
            'note_id' => $note_id,
            'title' => $this->createProvider[0]['title'],
            'body' => $this->createProvider[0]['body'],
            'user_id' => null,
            'timestamp' => date('Y-m-d H:i:s'),
        );
        $note = new NoteEntity();
        $note->exchangeArray($noteArray);

        // prepareing all Mock
        $tableMock = $this->getMock('Note\Db\NoteTable', array(), array($this->adapter), '', false);
        $resultSet = new NoteResultSet();
        $resultSet->initialize(array($noteArray));
        $sqlObj = new Sql($this->adapter);

        // preparing tableMock
        $tableMock->expects($this->once())
            ->method('getSql')
            ->will($this->returnValue($sqlObj));

        $tableMock->expects($this->once())
            ->method('selectWith')
            ->will($this->returnValue($resultSet));

        $noteResult = $this->noteCollection->setTable($tableMock)->get($note_id);
        $this->assertInstanceOf('Note\Entity\NoteEntity', $noteResult);
        $this->assertEquals($note, $noteResult);

        return $note;
    }

    /**
     * @depends testGet
     */
    public function testSave($note)
    {
        $note->setTitle($this->createProvider[1]['title']);
        $note->setBody($this->createProvider[1]['body']);

        $tableMock = $this->getMock('Note\Db\NoteTable', array(), array($this->adapter), '', false);
        $tableMock->expects($this->once())
            ->method('insert')
            ->with(
                $this->callback(array($this, 'tableMockCallbackOnSave'))
            );
        // todo manipulate database ini here
        $this->noteCollection->setTable($tableMock)->save($note);
    }

    public function tableMockCallbackOnSave($array)
    {
        $keyExpected = array('note_id', 'user_id', 'title', 'body');
        $keyReal = array_keys($array);
        sort($keyExpected);
        sort($keyReal);
        $this->assertSame($keyExpected, $keyReal);
        $this->assertEquals($this->createProvider[1]['title'], $array['title']);
        $this->assertEquals($this->createProvider[1]['body'], $array['body']);
        return $array['note_id'];
    }

    public function testDelete()
    {
        $this->markTestIncomplete();
    }

    public function testFilter()
    {
        $this->markTestIncomplete();
    }

    protected function noteEntityCreateProvider()
    {
        if (!$this->createProvider) {
            $noteEntityTest = new NoteEntityTest();
            $this->createProvider = $noteEntityTest->createProvider();
        }
        return $this->createProvider;
    
    }
}
