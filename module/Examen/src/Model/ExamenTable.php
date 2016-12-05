<?php

namespace Examen\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ExamenTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getExamen($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveExamen(Examen $examen)
    {
        $data = [
            'materia' => $examen->materia,
            'unidad'  => $examen->unidad,
        ];

        $id = (int) $examen->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getExamen($id)) {
            throw new RuntimeException(sprintf(
                 'Cannot update examen with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteExamen($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
    
}