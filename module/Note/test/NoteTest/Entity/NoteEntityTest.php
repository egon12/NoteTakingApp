<?php
/**
 * NoteEntityTest
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
 
namespace NoteTest\Entity;

use Note\Entity\NoteEntity;

class NoteEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testExchangeArray()
    {
        $note = new NoteEntity();

        $arr = array(
            'id'      => (int)(rand() * 100),
            'note_id' => uniqid(),
            'title'   => 'this is header',
            'body'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, \
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. \
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris \
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in  \
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla \
                pariatur. Excepteur sint occaecat cupidatat non proident, \
                sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'user_id' => (int)(rand() * 100),
            'timestamp' => date('Y-m-d H:i:s'),
        );

        $note->exchangeArray($arr);

        $this->assertSame($note->getId(), $arr['note_id']);
        $this->assertSame($note->getTitle(), $arr['title']);
        $this->assertSame($note->getBody(), $arr['body']);
        $this->assertSame($note->getUserId(), $arr['user_id']);
        $this->assertSame($note->getTimestamp(), $arr['timestamp']);

        $this->assertSame($note->getBodyExcerpt(), substr($arr['body'], 0, 80) . '...');
    }

    public function testSetTitle()
    {
        $note = new NoteEntity();

        $title1 = "Hello Jhony!";
        $title2 = "Welcome Home Andrew!";

        $note->setTitle($title1);
        $this->assertSame($title1, $note->getTitle());

        $note->setTitle($title2);
        $this->assertSame($title2, $note->getTitle());
    }

    public function testSetBody()
    {
        $note = new NoteEntity();

        $body1 = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore"
            . " et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut"
            . " aliquip ex ea commodo consequat. ";
        $body2 = "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur"
            . ". Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est "
            . "laborum.";

        $note->setBody($body1);
        $this->assertSame($body1, $note->getBody());

        $note->setBody($body2);
        $this->assertSame($body2, $note->getBody());
    }

    public function testSave()
    {
        $this->markTestIncomplete();
    }

    public function createProvider()
    {
        $arr = array();
        $arr[] = array (
            'title'     => 'Test Title',
            'body'      => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, '
                . 'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '
                . 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris '
                . 'nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in  '
                . 'reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla '
                . 'pariatur. Excepteur sint occaecat cupidatat non proident, '
                . 'sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'user_id'   => (int)(rand() * 100),
        );

        $arr[] = array(
            'title'     => 'Just One line Text',
            'body'      => 'Just One line of Text',
            'user_id'   => (int)(rand() * 100),
        );

        $arr[] = array(
            'title'     => 'Many new line',
            'body'      => "One\nTwo\nThree\nFour\nFive\nSix\nSeven\nEight\nNine\nTen\n",
            'user_id'   => (int)(rand() * 100),
        );

        return $arr;
    }
}
