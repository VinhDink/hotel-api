<?php

namespace App\Repositories;

class BookingRepository extends EloquentRepository
{
    /**
     * Get model
     */
    public function getModel()
    {
        return \App\Models\Booking::class;
    }

    /**
     * Getter for CHECKED_STATUS_TRUE
     *
     * @return bool
     */
    public function getCheckedStatusTrue()
    {
        return $this->_model::CHECKED_STATUS_TRUE;
    }

    /**
     * Getter for CHECKED_STATUS_FALSE
     *
     * @return bool
     */
    public function getCheckedStatusFalse()
    {
        return $this->_model::CHECKED_STATUS_FALSE;
    }

     /**
     * Getter for IS_CANCELLED_TRUE
     * 
     * @return bool
     */
    public function getIsCancelledTrue()
    {
        return $this->_model::IS_CANCEL_TRUE;
    }

    /**
     * Getter for IS_CANCELLED_FALSE
     * 
     * @return bool
     */
    public function getIsCancelledFalse()
    {
        return $this->_model::IS_CANCEL_FALSE;
    }

    /**
     * Get all unchecked booking
     *
     * @return object
     */
    public function index()
    {
        $result = $this->_model->where('checked', 0)->where('is_cancel', 0)->get(['id', 'guest_name', 'guest_number', 'arrive_date', 'leave_date', 'room_id', 'checked']);

        return $result;
    }

    /**
     * Get all booking
     *
     * @return object
     */
    public function getAllBooking()
    {
        $result = $this->_model->get(['id', 'guest_name', 'guest_number', 'arrive_date', 'leave_date', 'room_id', 'checked']);

        return $result;
    }

    /**
     * Get booking by id
     *
     * @param  int  $id
     * @return void
     */
    public function updateStatus($id)
    {
        $this->_model->where('id', $id)->update(['checked' => true]);
    }

    /**
     * Get guest Id
     *
     * @param  int  $id
     * @return int
     */
    public function getGuestId($id)
    {
        return $this->_model->where('id', $id)->first('guest_id');
    }

    /**
     * Get room Id
     *
     * @param  int  $id
     * @return object
     */
    public function getRoomId($id)
    {
        return $this->_model->where('id', $id)->first('room_id');
    }

    /**
     * Count total user booking
     *
     * @param  int  $id
     * @return int
     */
    public function countUserBooking($id)
    {
        return $this->_model->where('guest_id', $id)->count();
    }

    /**
     * Get all booking by user id
     *
     * @param  int  $id
     * @return object
     */
    public function getUserBooking($id)
    {
        return $this->_model->where('guest_id', $id)->get();
    }

    /**
     * Get arrive date
     *
     * @param  int  $id
     * @return string
     */
    public function getArriveDate($id)
    {
        return $this->_model->where('room_id', $id)->first('arrive_date');
    }

    /**
     * Get leave date
     *
     * @param  int  $id
     * @return string
     */
    public function getLeaveDate($id)
    {
        return $this->_model->where('room_id', $id)->first('leave_date');
    }

    /**
     * Check if booking exist
     *
     * @param  int  $id
     * @return bool
     */
    public function bookingExist($id)
    {
        return $this->_model->where('room_id', $id)->exists();
    }

    /**
     * Get booking detail
     *
     * @param  int  $id
     * @return object
     */
    public function getDetail($id)
    {
        return $this->_model->where('id', $id)->first(['id', 'guest_name', 'guest_number', 'created_at']);
    }

    /**
     * Get guest info
     *
     * @return object
     */
    public function guestInfo()
    {
        $result = $this->_model->join('checkins', 'bookings.id', '=', 'checkins.booking_id')
            ->select('bookings.id', 'bookings.guest_name', 'bookings.guest_number', 'checkins.fee', 'checkins.total_price', 'bookings.room_id')
            ->get();

        return $result;
    }

    /**
     * Get booking each month
     *
     * @return object
     */
    public function bookingEachMonth()
    {
        $result = $this->_model->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month');

        return $result;
    }

    /**
     * Get booking by room id
     *
     * @param  int  $id
     * @return object
     */
    public function getBookingByRoomId($id)
    {
        $result = $this->_model->where('room_id', $id)->get();

        return $result;
    }

    /**
     * Get bookings by rooms id
     *
     * @param  array  $id
     * @return object
     */
    public function getBookingByRoomsId($id)
    {
        $result = $this->_model->whereIn('room_id', $id)->get();

        return $result;
    }

    /**
     * Get guest statistic
     *
     * @return object
     */
    public function getGuestStatistic()
    {
        $result = $this->_model->join('users', 'bookings.guest_id', '=', 'users.id')
            ->selectRaw('bookings.guest_id, users.username, COUNT(*) as total_booking, users.email, COUNT(*) as booking_this_month, DATE_FORMAT(users.created_at, "%Y/%m/%d") as created_at')
            ->whereMonth('bookings.created_at', date('m'))->where('users.role', 'guest')
            ->groupBy('bookings.guest_id', 'users.username', 'users.email', 'users.created_at')
            ->get();

        $result->transform(function ($item) {
            $item->created_at = $item->created_at->format('Y/m/d');

            return $item;
        });

        return $result;
    }
}
