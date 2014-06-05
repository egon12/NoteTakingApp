<?php
/**
 * NoteControllerPostTest
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
 
namespace NoteTest\Controller;

use Note\Collection\NoteCollection;
use Note\Db\NoteTable;
use NoteTest\Bootstrap;
use Zend\Http\Request;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Stdlib\Parameters;

class NoteControllerPostTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfig.php'
        );
        parent::setUp();
        $sm = Bootstrap::getServiceManager();
        $this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
    }

    public function testEditPost()
    {
        // get availabel note
        $noteCollection = new NoteCollection(new NoteTable($this->adapter));
        $note = $noteCollection->fetch()->current();

        $params = array(
            'note_id' => $note->getId(),
            'title' => 'Satu Dua Tiga Empat',
            'body' => 'Nomornya kebalik?',
        );
        //var_dump($params);
        $this->dispatch('/note/edit/' . $note->getId(), Request::METHOD_POST, $params);
        $this->assertResponseStatusCode(200);
    }

    public function testAddPagePost()
    {
        $params = array(
            'title' => 'Satu Dua Tiga Empat',
            'body' => 'Nomornya kebalik?',
        );
        //var_dump($params);
        $this->dispatch('/note/add/', Request::METHOD_POST, $params);
        $this->assertResponseStatusCode(200);
        $this->assertRedirectTo('noteEdit');
    }
}
