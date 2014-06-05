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
 
namespace Note\Form;

use Zend\Form\Form;
use Zend\Form\Factory;

class NoteForm extends Form
{
    public function __construct()
    {
        parent::__construct('note');

        $note_id = array(
            'name' => 'note_id',
            'type' => 'hidden',
        );

        $head = array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => 'Title',
            ),
        );

        $body = array(
            'name' => 'body',
            'type' => 'textarea',
            'options' => array(
            ),
        );

        $submit = array(
            'name' => 'submit',
            'type' => 'submit',
            'options' => array(
            ),
        );

        $this->add($note_id);
        $this->add($head);
        $this->add($body);
        $this->add($submit);
    }
}
