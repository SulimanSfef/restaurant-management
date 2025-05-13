<?php

namespace App\Services;

use App\Repositories\TableRepository;

class TableService
{
    protected $tableRepository;

    public function __construct(TableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    public function getAllTables()
    {
        return $this->tableRepository->getAllTables();
    }

    public function createTable($data)
    {
        return $this->tableRepository->createTable($data);
    }

    public function getTableById($id)
    {
        return $this->tableRepository->getTableById($id);
    }

    public function updateTable($id, $data)
    {
        return $this->tableRepository->updateTable($id, $data);
    }

    public function deleteTable($id)
    {
        return $this->tableRepository->deleteTable($id);
    }
}

