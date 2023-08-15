<?php

namespace App\Http\Controllers;

use App\Jobs\ImportDataFromCsv;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    private $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Get room data
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        try {
            $result = $this->roomService->index();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('room.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Update room data
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function updateRoom(Request $request)
    {
        try {
            $this->roomService->update($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('room.update_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('room.update_success')]);
    }

    /**
     * Filter room
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function filterRoom(Request $request)
    {
        try {
            $result = $this->roomService->filter($request->all());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('room.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Get room detail
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function roomDetail(Request $request)
    {
        try {
            $result = $this->roomService->find($request->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('room.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Store room file
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function storeRoomFile(Request $request)
    {
        try {
            $this->roomService->storeRoomFile($request->file('file'));
            ImportDataFromCsv::dispatch();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('room.store_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('room.store_success')]);
    }
}
