<?php

namespace App\Repositories;

class RoomRepository extends EloquentRepository
{
    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Room::class;
    }

    /**
     * Getter for ROOM_STATUS_TRUE
     *
     * @return bool
     */
    public function getRoomStatusTrue()
    {
        return $this->_model::ROOM_STATUS_TRUE;
    }

    /**
     * Getter for ROOM_STATUS_FALSE
     *
     * @return bool
     */
    public function getRoomStatusFalse()
    {
        return $this->_model::ROOM_STATUS_FALSE;
    }

    /**
     * Get room price
     *
     * @param array
     */
    public function getPrice($id)
    {
        return $this->_model->where('id', $id)->first(['hour_price', 'day_price']);
    }

    /**
     * Get all room
     *
     * @return object
     */
    public function index()
    {
        $result = $this->_model->get(['id', 'name', 'type', 'hour_price', 'day_price', 'size']);

        return $result;
    }

    /**
     * Filter room
     *
     * @param  array  $data
     * @return object
     */
    public function filter($data)
    {
        $result = $this->_model->where($data)->where('status', 0)->get();

        return $result;
    }

    /**
     * Get rooms by id
     *
     * @param  array  $data
     * @return object
     */
    public function getRoomsById($data)
    {
        $result = $this->_model->whereIn('id', $data)->get();

        return $result;
    }

    /**
     * Get rooms id
     *
     * @return object
     */
    public function getRoomsId()
    {
        $result = $this->_model->pluck('id');

        return $result;
    }
}
