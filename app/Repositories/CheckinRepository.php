<?php

namespace App\Repositories;

use Illuminate\Support\Carbon;

class CheckinRepository extends EloquentRepository
{
    /**
     * Get model
     *
     * @return Model
     */
    public function getModel()
    {
        return \App\Models\Checkin::class;
    }

    /**
     * Display all checkin
     *
     * @return object
     */
    public function index()
    {
        $result = $this->_model->join('bookings', 'checkins.booking_id', '=', 'bookings.id')
                                ->where('checkins.status', 0)
                                ->select('checkins.id', 'checkins.booking_id', 'bookings.guest_name', 'checkins.checkin_time', 'checkins.checkout_time', 'checkins.fee', 'checkins.total_price')
                                ->get();

        return $result;
    }

    /**
     * Getter for CHECKIN_STATUS_TRUE
     *
     * @return bool
     */
    public function getCheckinStatusTrue()
    {
        return $this->_model::CHECKIN_STATUS_TRUE;
    }

    /**
     * Getter for CHECKIN_STATUS_FALSE
     *
     * @return bool
     */
    public function getCheckinStatusFalse()
    {
        return $this->_model::CHECKIN_STATUS_FALSE;
    }

    /**
     * Getter for FIRST_3_HOUR
     *
     * @return int
     */
    public function getFirst3Hour()
    {
        return $this->_model::FIRST_3_HOUR;
    }

    /**
     * Getter for DIFF_LESS_THAN_1
     *
     * @return int
     */
    public function getDiffLessThan1()
    {
        return $this->_model::DIFF_LESS_THAN_1;
    }

    /**
     * Getter for ID_EXIST_TRUE
     *
     * @return bool
     */
    public function getIdExistTrue()
    {
        return $this->_model::ID_EXIST_TRUE;
    }

    /**
     * Count checkin today
     *
     * @param  string  $todayTime
     * @return int
     */
    public function countCheckinToday($todayTime)
    {
        $result = $this->_model->where('checkin_time', 'LIKE', $todayTime.'%')->count();

        return $result;
    }

    /**
     * Count checkin this week
     *
     * @param  date  $last7daysTime
     * @return int
     */
    public function countCheckinThisWeek($last7daysTime)
    {
        $result = $this->_model->where('checkin_time', '>=', $last7daysTime)->count();

        return $result;
    }

    /**
     * Count checkin last month
     *
     * @param  date  $lastMonthTime
     * @return int
     */
    public function countCheckinLastMonth($lastMonthTime)
    {
        $result = $this->_model->where('checkin_time', '>=', $lastMonthTime)->count();

        return $result;
    }

    /**
     * Sum total checkin today
     *
     * @param  date  $lastMonthTime
     * @return int
     */
    public function sumTotalLastMonth($lastMonthTime)
    {
        $result = $this->_model->where('checkin_time', '>=', $lastMonthTime)->sum('total_price');

        return $result;
    }

    /**
     * Get checkin today
     *
     * @return object
     */
    public function getCheckinToday()
    {
        $result = $this->_model->join('bookings', 'checkins.booking_id', '=', 'bookings.id')
        ->select('checkins.id', 'bookings.guest_name', 'bookings.guest_number', 'bookings.room_id', 'checkins.checkin_time')
        ->where('checkins.checkin_time', 'LIKE', Carbon::now()->toDateString().'%')
        ->get();

        return $result;
    }

    /**
     * Calculate interest each month
     *
     * @return object
     */
    public function interestEachMonth()
    {
        $result = $this->_model->selectRaw('MONTH(checkout_time) as month, SUM(total_price) as sum')
        ->whereYear('checkin_time', date('Y'))
        ->groupBy('month')
        ->pluck('sum', 'month');

        return $result;
    }

    /**
     * Calculate interest this month
     *
     * @return int
     */
    public function interestThisMonth()
    {
        $result = $this->_model->whereMonth('checkin_time', date('m'))->sum('total_price');

        return $result;
    }

    /**
     * Get employee Id
     *
     * @param  int  $checkinId
     * @return object
     */
    public function getEmployeeId($bookingId)
    {
        $result = $this->_model->where('id', $bookingId)->first('employee_id');

        return $result;
    }

    /**
     * Delete used checkin
     *
     * @param  int  $bookingId
     * @return object
     */
    public function deleteUsedCheckin()
    {
        $result = $this->_model->whereNotNull('checkout_time')->delete();

        return $result;
    }
}
