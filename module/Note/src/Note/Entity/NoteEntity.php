<?php
/**
 * NoteEntity
 * 
 * NoteEntity digunakan untuk membuat pengaman untuk note.
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
 
namespace Note\Entity;

use Zend\Stdlib\ArraySerializableInterface;

class NoteEntity implements ArraySerializableInterface
{
    protected $id;
    protected $note_id;
    protected $title;
    protected $body;
    protected $user_id;
    protected $timestamp;

    protected $longExcerpt = 80;

    public function getId()
    {
        return $this->note_id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function getBodyExcerpt()
    {
        return substr($this->body, 0, 80) . '...';
    }

    public function getUserId()
    {
        return $this->user_id;
    }
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function exchangeArray(array $data)
    {
        // must exists todo maybe need something? throw Exception or else
        $this->title    = $data['title'];
        $this->body     = $data['body'];

        $this->id       = isset($data['id'])       ? $data['id']       : null;
        $this->note_id  = isset($data['note_id'])  ? $data['note_id']  : null;
        $this->user_id  = isset($data['user_id'])  ? $data['user_id']  : null;
        $this->timestamp= isset($data['timestamp'])? $data['timestamp']  : null;
    }

    public function getArrayCopy()
    {
        return array(
            'id'        => $this->id,
            'note_id'   => $this->note_id,
            'title'     => $this->title,
            'body'      => $this->body,
            'user_id'   => $this->user_id,
            'timestamp' => $this->timestamp
        );
    }
}
