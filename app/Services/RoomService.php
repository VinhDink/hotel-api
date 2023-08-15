<?php

namespace App\Services;

use App\Repositories\RoomRepository;
use Illuminate\Support\Facades\Storage;

class RoomService
{
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * Get room data
     *
     * @return object
     */
    public function index()
    {
        $result = $this->roomRepository->index();

        return $result;
    }

    /**
     * Update room data
     *
     * @param  Request  $req
     * @return void
     */
    public function update($req)
    {
        $credential = $req->all();
        $imageFields = ['image_first', 'image_second', 'image_third'];
    
        foreach ($imageFields as $field) {
            if (array_key_exists($field, $credential)) {
                $path = $req->file($field)->store('public/image');
                $credential[$field] = Storage::url('image/' . basename($path));
            }
        }
    
        $this->roomRepository->update($credential['id'], $credential);
    }

    /**
     * Filter room
     *
     * @param  array  $data
     * @return object
     */
    public function filter($data)
    {
        $filteredData = array_filter($data, function ($value) {
            return $value !== null;
        });

        $result = $this->roomRepository->filter($filteredData);

        return $result;
    }

    /**
     * Find room by id
     *
     * @param  int  $id
     * @return object
     */
    public function find($id)
    {
        $result = $this->roomRepository->find($id);

        return $result;
    }

    /**
     * Store room data
     *
     * @param  object  $data
     * @return void
     */
    public function storeRoomFile($data)
    {
        $data->storeAs('room_data', 'data.csv');
    }
}
