<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Requests\FilterByDateRequest;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        try {
            $result = $this->bookingService->index();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.get_failed')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(BookingRequest $request)
    {
        try {
            $validated = $request->all();
            $result = $this->bookingService->store($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.create_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($result) {
            return response()->json(['message' => __('booking.create_success')]);
        }

        return response()->json(['message' => __('booking.create_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $req
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function checkAvailability(Request $request)
    {
        try {
            $result = $this->bookingService->checkAvailability($request->all());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.check_available_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $req
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function cancel(Request $request)
    {
        try {
            $id = $request->id;
            $this->bookingService->cancel($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.delete_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('booking.delete_success')]);
    }

    /**
     * Checkin a booking collection
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function checkin(Request $request)
    {
        try {
            $this->bookingService->checkin($request->all());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.checkin_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('booking.checkin_success')]);
    }

    /**
     * Count all booking by user id
     *
     *  @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function countUserBooking($id)
    {
        try {
            $count = $this->bookingService->countUserBooking($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.count_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($count);
    }

    /**
     * Get all booking by user id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getUserBooking($id)
    {
        try {
            $booking = $this->bookingService->getUserBooking($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($booking);
    }

    /**
     * Show all available room
     *
     * @param  Request  $request
     *
     * return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function showAvailableRoom(Request $request)
    {
        try {
            info($request->id);
            $result = $this->bookingService->showAvailableRoom($request->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Filter booking by date
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function filterByDate(FilterByDateRequest $request)
    {
        info($request->all());
        try {
            $result = $this->bookingService->filterByDate($request->all());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('booking.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Get guest statistic
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getGuestStatistic()
    {
        try {
            $result = $this->bookingService->getGuestStatistic();
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());

            return response()->json(['message' => __('booking.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }
}
