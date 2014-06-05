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
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class NoteCollection implements NoteCollectionInterface
{
    use ServiceLocatorAwareTrait;

    protected $authenticationService;

    protected $table;

    protected $limit = 12;

    public function __construct(NoteTable $table)
    {
        $this->table = $table;
    }

    public function setTable(NoteTable $table)
    {
        $this->table = $table;
        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function fetch($offset = 0)
    {
        $sql = $this->table->getSql()->select();

        // the magic from stackoverflow
        $sql->join(array('n' => 'note'), 'note.note_id = n.note_id and note.id < n.id', array(), 'left');
        $sql->where('n.id is null');
        
        // set order limit and offset
        $sql->order(array('timestamp' => $sql::ORDER_DESCENDING));
        $sql->limit($this->limit);
        $sql->offset($offset);

        // execute
        return $this->table->selectWith($sql);
    }

    public function create(NoteEntity $note)
    {
        // todo error checking
        $array = $note->getArrayCopy();
        $array['note_id'] = uniqid();
        $array['user_id'] = $this->authentication()->getIdentity()->getId();
        $this->table->insert($array);


        return $array['note_id'];
    }

    public function get($id)
    {
        $sql = $this->table->getSql()->select();

        // get the last
        $sql->where(array('note_id' => $id));
        $sql->order(array('id' => $sql::ORDER_DESCENDING));
        $sql->limit(1);

        // execute
        $resultSet = $this->table->selectWith($sql);
        return $resultSet->current();
    }

    public function save(NoteEntity $note)
    {
        $array = $note->getArrayCopy();
        // $array['updated'] = date('Y-m-d H:i:s');
        // todo analyze did this create time is needed
        // $array['created'] = null;
        // $array['id'] = null;
        unset($array['id']);
        unset($array['timestamp']);
        $array['user_id'] = $this->authentication()->getIdentity()->getId();

        $this->table->insert($array);

        return $this->table->lastInsertValue;
    }

    public function delete($note_id)
    {
        $this->table->delete(array('note_id' => $note_id));
    }

    public function setLimit($limit)
    {
        if (!is_numeric($limit)) {
            throw Exception('Invalide Argument Type for NoteCollection limit');
        }
        $this->limit = $limit;
    }

    protected function authentication()
    {
        if (!$this->authenticationService) {
            $this->authenticationService = $this->getServiceLocator()->get('zfcuser_auth_service');
        }
        return $this->authenticationService;
    }
}
