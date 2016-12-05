<?php

namespace Pregunta\Controller;

use Pregunta\Form\PreguntaForm;
use Pregunta\Model\Pregunta;
use Pregunta\Model\PreguntaTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PreguntaController extends AbstractActionController
{
    // Add this property:
    private $table;
    static $id_examen;
    

    // Add this constructor:
    public function __construct(PreguntaTable $table)
    {
        $this->table = $table;
       // $id_examen= (int) $this->params()->fromRoute('id_pregunta', 0);
    }

    public function indexAction()
    {
       // $form = new PreguntaForm();
        //$form->get('id_examen')->setValue((int) $this->params()->fromRoute('id_pregunta', 0));
        return new ViewModel([
            $id_examen = (int) $this->params()->fromRoute('id_pregunta', 0),
            'id_examen' => $this->params()->fromRoute('id_pregunta', 0),
            //$form->get('id_examen')->setValue((int) $this->params()->fromRoute('id_pregunta', 0)),
             //$id_pregunta = (int) $this->params()->fromRoute('id_pregunta', 0),
            'preguntas' => $this->table->fetchAll($id_examen),
            
            //'preguntas' => $this->table->getAsociadas($id_pregunta),
        ]);
    }
    
    public function getIdExamen()
    {
        return $this->params()->fromRoute('id_pregunta', 0);
    }

    public function addAction()
    {
       
        $form = new PreguntaForm();
        
        $form->get('submit')->setValue('Add');
        $id_examen= (int) $this->params()->fromRoute('id_pregunta', 0);
        $form->get('id_examen')->setValue($id_examen);

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $pregunta = new Pregunta();
        $form->setInputFilter($pregunta->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
      
        $pregunta->exchangeArray($form->getData());
        $this->table->savePregunta($pregunta);

        return $this->redirect()->toRoute('pregunta',['action' => 'index','id_pregunta'=> $id_examen]);
    }

    public function editAction()
    {
        $form = new PreguntaForm();
        //$id_examen=$form->getValue('id_examen');
        
        $id_pregunta = (int) $this->params()->fromRoute('id_pregunta', 0);
        //revisar este error
        
        $id_examen=$this->table->getExamen($id_pregunta);

       
        if (0 === $id_pregunta) {
            return $this->redirect()->toRoute('pregunta', ['action' => 'add','id_pregunta'=>$id_examen]);
        }

     
        try {
            $pregunta = $this->table->getPregunta($id_pregunta);

        } catch (\Exception $e) {
            return $this->redirect()->toRoute('pregunta', ['action' => 'index','id_pregunta'=> $id_examen]);
        }

        
        $form->bind($pregunta);
       // $form->get('id_examen')->setValue((int) $this->params()->fromRoute('id_pregunta', 0));
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id_pregunta' => $id_pregunta, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($pregunta->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->savePregunta($pregunta);

        // Redirect to Pregunta list

      // $examen=$this->$pregunta->$id_examen;
       
        return $this->redirect()->toRoute('pregunta', ['action' => 'index', 'id_pregunta'=> $id_examen]);
    }

    public function deleteAction()
    {
        $id_pregunta = (int) $this->params()->fromRoute('id_pregunta', 0);
        $form = new PreguntaForm();
        $id_examen=$this->table->getExamen($id_pregunta);
        if (!$id_pregunta) {
            return $this->redirect()->toRoute('pregunta');
        }

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Si') {
                $id_pregunta = (int) $request->getPost('id_pregunta');
                $this->table->deletePregunta($id_pregunta);
            }

            // Redirect to list of Preguntas
            return $this->redirect()->toRoute('pregunta', ['action' =>'index', 'id_pregunta'=> $id_examen]);
        }

        return [
            'id_pregunta'    => $id_pregunta,
            'pregunta' => $this->table->getPregunta($id_pregunta),
        ];
    }
    
}
