<?php
/**
 * NoteResultSet
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
 
namespace Note\Db;

use Note\Entity\NoteEntity;
use Zend\Db\ResultSet\ResultSet;

class NoteResultSet extends ResultSet
{
    public function __construct()
    {
        parent::__construct(parent::TYPE_ARRAYOBJECT, new NoteEntity());
    }
}
