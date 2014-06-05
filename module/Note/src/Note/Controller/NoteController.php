<?php

namespace Note\Controller;

use Note\Collection\NoteCollection;
use Note\Collection\NoteHistory;
use Note\Entity\NoteEntity;
use Note\Form\NoteForm;
use Note\Db\NoteTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class NoteController extends AbstractActionController
{
    protected $collection;

    protected $history;

    protected $user;

    public function indexAction()
    {
        $userMapper = $this->user()->getUserMapper();
        return new ViewModel(array(
            'notes' => $this->collection()->fetch(),
            'userMapper' => $userMapper
        ));
    }

    public function addAction()
    {
        $form = new NoteForm();
        $note = new NoteEntity();
        $form->get('submit')->setValue('Create');
        $form->bind($note);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $note_id = $this->collection()->create($note);
                return $this->redirect()->toRoute('noteEdit', array('id' => $note_id));
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('note');
            // todo add flash message
        }

        $note = $this->collection()->get($id);

        if (!$note) {
            return $this->redirect()->toRoute('note');
            // todo add flash message
        }

        $form = new NoteForm();
        $form->bind($note);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->collection()->save($note);
            }
        }

        $form->get('submit')->setValue('Save');

        return new ViewModel(array(
            'form' => $form,
            'history' => $this->history()->get($id)
        ));
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        
        $this->collection()->delete($id);

        return $this->redirect()->toRoute('note');
    }

    protected function collection()
    {
        if (!$this->collection) {
            $serviceLocator = $this->getServiceLocator();
            $adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
            $this->collection = new NoteCollection(new NoteTable($adapter));
            $this->collection->setServiceLocator($serviceLocator);
        }
        return $this->collection;
    }

    protected function history()
    {
        if (!$this->history) {
            $serviceLocator = $this->getServiceLocator();
            $adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
            $this->history = new NoteHistory($adapter);
        }
        return $this->history;
    }

    protected function user()
    {
        if (!$this->user) {
            $serviceLocator = $this->getServiceLocator();
            $this->user = $serviceLocator->get('zfcuser_user_service');
        }
        return $this->user;

    }
}
