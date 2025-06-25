<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Services\TableService;
use App\Traits\ApiResponseTrait;

class TableController extends Controller
{
    use ApiResponseTrait;

    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index()
    {
        $tables = $this->tableService->getAllTables();
        return $this->successResponse($tables, 'All tables retrieved successfully');
    }

    public function store(TableRequest $request)
    {
        $table = $this->tableService->createTable($request->validated());
        return $this->successResponse($table, 'Table created successfully', 201);
    }

    public function show($id)
    {
        try {
            $table = $this->tableService->getTableById($id);
            return $this->successResponse($table, 'Table retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Table not found', 404);
        }
    }

    public function update(UpdateTableRequest $request, $id)
    {
        try {
            $table = $this->tableService->updateTable($id, $request->validated());
            return $this->successResponse($table, 'Table updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update table', 400, ['exception' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tableService->deleteTable($id);
            return $this->successResponse(null, 'Table deleted successfully', 204);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete table', 400, ['exception' => $e->getMessage()]);
        }
    }

    public function getTablesByCapacity($peopleCount)
    {
        try {
            $tables = $this->tableService->getAvailableTablesByCapacity($peopleCount);
            return $this->successResponse($tables, "Tables suitable for {$peopleCount} people retrieved");
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve tables', 500, ['exception' => $e->getMessage()]);
        }
    }

    public function tablesSortedByReservations()
{
    $tables = $this->tableService->getTablesSortedByReservations();
    return $this->successResponse($tables, 'Tables sorted by reservation count');
}

}
