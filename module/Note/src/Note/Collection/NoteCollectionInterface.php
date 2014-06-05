<?php
/**
 * NoteCollection
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

interface NoteCollectionInterface
{
    public function __construct(NoteTable $table);

    public function setTable(NoteTable $table);

    public function getTable();

    public function fetch($offset = 0);

    public function create(NoteEntity $note);

    public function get($id);

    public function save(NoteEntity $note);

    public function delete($note_id);

    public function setLimit($limit);
}
