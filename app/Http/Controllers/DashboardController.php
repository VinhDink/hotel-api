<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use App\Services\CheckinService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    private $bookingService;

    private $checkinService;

    public function __construct(BookingService $bookingService, CheckinService $checkinService)
    {
        $this->bookingService = $bookingService;
        $this->checkinService = $checkinService;
    }

    /**
     * Get dashboard data
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        try {
            $result = $this->bookingService->dashboard();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('dashboard.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Get all checkin created today
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getCheckinToday()
    {
        try {
            $result = $this->checkinService->getCheckinToday();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('dashboard.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Count booking each month of this year
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function bookingEachMonth()
    {
        try {
            $result = $this->bookingService->bookingEachMonth();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('dashboard.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Sum interest each month of this year
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function interestEachMonth()
    {
        try {
            $result = $this->checkinService->interestEachMonth();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('dashboard.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Calculate income after all expenses
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function incomeAfterExpense()
    {
        try {
            $result = $this->checkinService->incomeAfterExpense();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('dashboard.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }
}
