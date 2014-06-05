<?php
/**
 * NoteTableGateway
 * 
 * todo create TableCreator
 * and table modifier?
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

use Note\Db\NoteResultSet;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class NoteTable extends TableGateway
{
    public function __construct(AdapterInterface $adapter, $features = null)
    {
        // set the Table
        $table = 'note';

        // ResultSet
        $resultSetPrototype = new NoteResultSet();

        //and Execute
        parent::__construct($table, $adapter, $features, $resultSetPrototype, null);
    }

    public function createTable()
    {
        // todo create for another databases
        // for MySQL
        $columns = array(
            'id int primary key auto_increment',
            'note_id char(13)',
            'title varchar(512)',
            'body text',
            'user_id int',
            'timestamp timestamp'
        );
    }
}
