<?php
namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Services\TableService;

class TableController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index()
    {
        return response()->json($this->tableService->getAllTables());
    }

    public function store(TableRequest $request)
    {
        return response()->json($this->tableService->createTable($request->validated()), 201);
    }

    public function show($id)
    {
        return response()->json($this->tableService->getTableById($id));
    }

    public function update(TableRequest $request, $id)
    {
        return response()->json($this->tableService->updateTable($id, $request->validated()));
    }

    public function destroy($id)
    {
        return response()->json($this->tableService->deleteTable($id), 204);
    }
}
