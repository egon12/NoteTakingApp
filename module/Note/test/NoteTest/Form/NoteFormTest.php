<?php
/**
 * NoteForm
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
 
namespace NoteTestForm;

use Note\Form\NoteForm;

class NoteFormTest extends \PHPUnit_Framework_TestCase
{
    public function testIntegrityData()
    {
        $form = new NoteForm();

        // $formElements = $form->getElements();
        $this->assertTrue($form->has('note_id'), '"note_id" not exists');
        $head = $form->get('note_id');
        $this->assertInstanceOf('Zend\Form\Element\Hidden', $head, '"note_id" input type is not hidden');

        $this->assertTrue($form->has('title'), '"title" not exists');
        $head = $form->get('title');
        $this->assertInstanceOf('Zend\Form\Element\Text', $head, '"title" input type is not text');

        $this->assertTrue($form->has('body'), '"body" not exists');
        $body = $form->get('body');
        $this->assertInstanceOf('Zend\Form\Element\TextArea', $body, '"body" input type is not textarea');

        $this->assertTrue($form->has('submit'), '"submit" not exists');
        $submit = $form->get('submit');
        $this->assertInstanceOf('Zend\Form\Element\Submit', $submit, '"submit" input type is not textarea');
    }
}
