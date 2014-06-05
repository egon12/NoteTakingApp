<?php
/**
 * NoteHistory
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
 
namespace Note\Collection;

use Note\Db\NoteTable;
use Note\Entity\NoteEntity;

class NoteHistory extends NoteTable
{
    public function get($id)
    {
        $sql = $this->sql->select();

        $sql->columns(array(
            'note_id' => 'id',
            'title' => 'title',
            'body' => 'body',
            'user_id' => 'user_id',
            'timestamp' => 'timestamp',
        ));

        // get the last
        $sql->where(array('note_id' => $id));
        $sql->order(array('id' => $sql::ORDER_DESCENDING));

        // execute
        return $this->selectWith($sql);
    }
}
