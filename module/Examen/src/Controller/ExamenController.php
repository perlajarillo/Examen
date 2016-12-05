<?php

namespace Examen\Controller;

use Examen\Form\ExamenForm;
use Examen\Model\Examen;
use Examen\Model\ExamenTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ExamenController extends AbstractActionController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(ExamenTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'examenes' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ExamenForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $examen = new Examen();
        $form->setInputFilter($examen->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $examen->exchangeArray($form->getData());
        $this->table->saveExamen($examen);
        return $this->redirect()->toRoute('examen');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('examen', ['action' => 'add']);
        }

        // Retrieve the Examen with the specified id. Doing so raises
        // an exception if the Examen is not found, which should result
        // in redirecting to the landing page.
        try {
            $examen = $this->table->getExamen($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('examen', ['action' => 'index']);
        }

        $form = new ExamenForm();
        $form->bind($examen);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($examen->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveExamen($examen);

        // Redirect to Examen list
        return $this->redirect()->toRoute('examen', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('examen');
        }

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Si') {
                $id = (int) $request->getPost('id');
                $this->table->deleteExamen($id);
            }

            // Redirect to list of Examens
            return $this->redirect()->toRoute('examen');
        }

        return [
            'id'    => $id,
            'examen' => $this->table->getExamen($id),
        ];
    }
    
}
