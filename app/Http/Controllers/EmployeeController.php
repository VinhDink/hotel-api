<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Get all data
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        try {
            $result = $this->employeeService->index();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('employee.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }
}
