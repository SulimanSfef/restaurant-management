<?php
namespace App\Repositories;

use App\Models\Table;

class TableRepository
{
    public function getAllTables()
    {
        return Table::all();
    }

    public function createTable($data)
    {
        return Table::create($data);
    }

    public function getTableById($id)
    {
        return Table::findOrFail($id);
    }

    public function updateTable($id, $data)
    {
        $table = Table::findOrFail($id);
        $table->update($data);
        return $table;
    }

    public function deleteTable($id)
    {
        $table = Table::findOrFail($id);
        return $table->delete();
    }
}

