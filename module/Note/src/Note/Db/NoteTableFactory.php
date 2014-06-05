<?php
/**
 * NoteTableFactory
 * 
 * This class is suing Zend\Db\Sql\Ddl library.
 * Unfortunately, the library is not done yet, 
 * and many missing features except for mysql.
 * For now it only generate and MySQL sql statement
 * to create Note Table
 *
 * And it's still note complete yet.. (missing 
 * timestamp)
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

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Ddl\Column\Char;
use Zend\Db\Sql\Ddl\Column\Date;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Column\Text;
use Zend\Db\Sql\Ddl\Column\Varchar;

class NoteTableFactory
{
    public static function createTable(AdapterInterface $adapter)
    {
        $sqlObject = new Sql($adapter);
        $platform = $sqlObject->getSqlPlatform();
        
        $tableCreator = $platform->getDecorators()['Zend\Db\Sql\Ddl\CreateTable'];
        //$tableCreator = new CreateTable('notetemp', true);
        
        $tableCreator->setTable('notetemp');

        foreach (static::createColumn() as $colName => $colObj) {
            $tableCreator->addColumn($colObj);
        }

        // todo find what is this for?
        $tableCreator->setSubject($tableCreator);

        // $sql = $tableCreator->getSqlString($adapter->getPlatform());
        $sql = $tableCreator->getSqlString();
        return $sql;
    }

    protected static function createColumn()
    {
        $columns = array();

        $columns['id'] = new Integer('id', false, null, array('serial' => true));

        $columns['note_id'] = new Char('note_id', 13);
        $columns['note_id']->setNullable(true);

        $columns['title'] = new Varchar('title', 512);
        $columns['title']->setNullable(true);

        $columns['body'] = new Text('body');
        $columns['body']->setNullable(true);

        $columns['timestamp'] = new Date('timetamp');

        return $columns;
    }
}
