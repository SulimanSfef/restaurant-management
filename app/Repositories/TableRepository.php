<?php
namespace App\Repositories;

use App\Models\Table;
use App\Models\Reservation;
use Carbon\Carbon;


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

    // في TableRepository.php
public function getTablesByCapacity($peopleCount)
{

    return Table::where('capacity', '>=', $peopleCount)
                ->where('status', 'available') // لو عندك حالة للطاولة مثلا متاحة أو محجوزة
                ->get();

}

public function getTablesSortedByReservations()
{
    return \App\Models\Table::withCount('reservations')
        ->orderBy('reservations_count', 'asc')
        ->get();
}

public function getReservationsForTable($tableId)
{
    return Reservation::where('table_id', $tableId)->get();
}

public function findByNumber($number)
{
    return Table::where('table_number', $number)->first();
}

public function findByMinCapacity($minCapacity)
{
    return Table::where('capacity', '>=', $minCapacity)->orderBy('capacity')->get();
}



}

