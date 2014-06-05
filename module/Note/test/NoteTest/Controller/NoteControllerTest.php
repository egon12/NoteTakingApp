<?php
/**
 * NoteControllerTest
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
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class NoteControllerTest extends AbstractHttpControllerTestCase
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

    public function testIndexPage()
    {
        $this->dispatch('/note/index');
        $this->assertResponseStatusCode(200);

        $this->reset();
        $this->dispatch('/note');
        $this->assertResponseStatusCode(200);

        $this->assertXpathQuery('//table[@id="notes"]');
    }

    public function testEditPage()
    {
        // test without id
        $this->dispatch('/note/edit');
        $this->assertRedirectRegex('/note/');

        // test false id
        $this->reset();
        $this->dispatch('/note/edit/abcdef');
        $this->assertRedirectRegex('/note/');

        // test the real one
        $this->reset();
        $noteCollection = new NoteCollection(new NoteTable($this->adapter));
        $note = $noteCollection->fetch()->current();
        $this->dispatch('/note/edit/' . $note->getId());
        $this->assertNotRedirect();
        $this->assertResponseStatusCode(200);
        $this->assertXpathQuery('//form[@id="note"]//input[@name="note_id"]');
        $this->assertXpathQuery('//form[@id="note"]//input[@name="title"]');
        $this->assertXpathQuery('//form[@id="note"]//textarea[@name="body"]');
        $this->assertXpathQuery('//form[@id="note"]//input[@type="submit"]');
        $this->assertXpathQuery('//form[@id="note"]//input[@value="Save"]');
    }

    public function testAddPage()
    {
        $this->dispatch('/note/add');
        $this->assertResponseStatusCode(200);

        $this->assertXpathQuery('//form[@id="note"]//input[@name="title"]');
        $this->assertXpathQuery('//form[@id="note"]//textarea[@name="body"]');
        $this->assertXpathQuery('//form[@id="note"]//input[@type="submit"]');
        $this->assertXpathQuery('//form[@id="note"]//input[@value="Create"]');
    }

    public function testDeletePage()
    {
        $this->dispatch('/note/delete');
        $this->assertResponseStatusCode(200);
    }
}
