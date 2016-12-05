<?php

namespace Respuesta\Controller;

use Respuesta\Form\RespuestaForm;
use Respuesta\Model\Respuesta;
use Respuesta\Model\RespuestaTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RespuestaController extends AbstractActionController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(RespuestaTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        
        return new ViewModel([
             $id_pregunta = (int) $this->params()->fromRoute('id_respuesta', 0),
            'id_pregunta' => $this->params()->fromRoute('id_respuesta', 0),
            'respuestas' => $this->table->fetchAll($id_pregunta),
        ]);
    }

    public function addAction()
    {
        $form = new RespuestaForm();
        $form->get('submit')->setValue('Add');
        $id_pregunta= (int) $this->params()->fromRoute('id_respuesta', 0);
        $form->get('id_pregunta')->setValue($id_pregunta);

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $respuesta = new Respuesta();
        $form->setInputFilter($respuesta->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $respuesta->exchangeArray($form->getData());
        $this->table->saveRespuesta($respuesta);
        return $this->redirect()->toRoute('respuesta', ['action' => 'index', 'id_respuesta'=>$id_pregunta]);
    }
    public function returnPregunta()
    {
        return $id_pregunta = (int) $this->params()->fromRoute('id_respuesta', 0);
    }

    public function editAction()
    {
        
        $id_respuesta= (int) $this->params()->fromRoute('id_respuesta', 0);

        $id_pregunta=$this->table->getPregunta($id_respuesta);

        if (0 === $id_respuesta) {
            return $this->redirect()->toRoute('respuesta', ['action' => 'add']);
        }

     
        try {
            $respuesta = $this->table->getRespuesta($id_respuesta);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('respuesta', ['action' => 'index', 'id_respuesta'=>$id_pregunta]);
        }

        $form = new RespuestaForm();

        $form->bind($respuesta);
        $form->get('submit')->setAttribute('value', 'Edit');
       // $form->get('id_pregunta')->setValue($this->returnPregunta());

        $request = $this->getRequest();
        $viewData = ['id_respuesta' => $id_respuesta, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($respuesta->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveRespuesta($respuesta);

        // Reedirecciona a lista de respuestas
        return $this->redirect()->toRoute('respuesta', ['action' => 'index', 'id_respuesta'=>$id_pregunta]);
    }

    public function deleteAction()
    {
        $id_respuesta = (int) $this->params()->fromRoute('id_respuesta', 0);
        $id_pregunta=$this->table->getPregunta($id_respuesta);

        if (!$id_respuesta) {
            return $this->redirect()->toRoute('respuesta');
        }

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Si') {
                $id_respuesta = (int) $request->getPost('id_respuesta');
                $this->table->deleteRespuesta($id_respuesta);
            }

            // Reedirecciona a lista de respuestas
            return $this->redirect()->toRoute('respuesta',['action' => 'index', 'id_respuesta'=>$id_pregunta]);
        }

        return [
            'id_respuesta'    => $id_respuesta,
            'respuesta' => $this->table->getRespuesta($id_respuesta),
        ];
    }
    
}
