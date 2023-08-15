<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeeRequest;
use App\Jobs\ExportDataToCsv;
use App\Services\BookingService;
use App\Services\CheckinService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CheckinController extends Controller
{
    private $checkinService;

    private $employeeService;

    private $bookingService;

    public function __construct(CheckinService $checkinService, EmployeeService $employeeService, BookingService $bookingService)
    {
        $this->checkinService = $checkinService;
        $this->employeeService = $employeeService;
        $this->bookingService = $bookingService;
    }

    /**
     * Get all data
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        try {
            $result = $this->checkinService->index();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('checkin.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Update checkout time
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function checkout(Request $request)
    {
        try {
            $this->checkinService->checkout($request->id, $request->bookingId);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('checkin.checkout_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('checkin.checkout_success')]);
    }

    /**
     * Delete a checkin record
     *
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function removeCheckin(Request $request)
    {
        try {
            $this->checkinService->remove($request->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('checkin.delete_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('checkin.delete_success')]);
    }

    /**
     * This function update the fee of a booking
     *
     * @param  FeeRequest  $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function updateFee(Request $request)
    {
        try {
            $this->checkinService->updateFee($request->id, $request->input('fee'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('checkin.update_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('checkin.update_success')]);
    }

    /**
     * This function return employee and booking info
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function viewDetail(Request $request)
    {
        try {
           $result = $this->checkinService->getDetail($request->bookingId, $request->checkinId);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('checkin.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * This function export data to csv file
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function exportData()
    {
        try {
            ExportDataToCsv::dispatch()->onConnection('sync')->onQueue('exports');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('checkin.export_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->download(storage_path('app/export/data.csv'), 'data.csv');
    }
}
