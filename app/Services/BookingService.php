<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use App\Repositories\CheckinRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\RoomRepository;
use Illuminate\Support\Carbon;

class BookingService
{
    private $bookingRepository;

    private $roomRepository;

    private $employeeRepository;

    private $checkinRepository;

    public function __construct(BookingRepository $bookingRepository, RoomRepository $roomRepository, EmployeeRepository $employeeRepository, CheckinRepository $checkinRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->roomRepository = $roomRepository;
        $this->employeeRepository = $employeeRepository;
        $this->checkinRepository = $checkinRepository;
    }

    /**
     * Store booking
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data)
    {
        $bookingArrive = Carbon::createFromFormat('Y-m-d', $data['arrive_date']);
        $bookingLeave = Carbon::createFromFormat('Y-m-d', $data['leave_date']);
        $roomId = $data['room_id'];
        $bookingCollection = $this->bookingRepository->index();

        $valid = $this->isBookingValid($bookingCollection, $roomId, $bookingArrive, $bookingLeave);

        if ($valid) {
            $this->bookingRepository->store($data);
            return true;
        }

        return false;
    }

    /**
     * Checkin booking
     *
     * @param array $req
     * @return void
     */
    public function checkin($req)
    {
        $id = $req['id'];

        $this->bookingRepository->update($id, ['checked' => $this->bookingRepository->getCheckedStatusTrue()]);

        $hour = date('H:i');
        if ($hour <= $this->employeeRepository->getHourFirstShift()) {
            $shift = $this->employeeRepository->getFirstShift();
        } elseif ($hour > $this->employeeRepository->getHourFirstShift() && $hour <= $this->employeeRepository->getHourSecondShift()) {
            $shift = $this->employeeRepository->getSecondShift();
        } else {
            $shift = $this->employeeRepository->getThirdShift();
        }

        $checkinEmployee = $this->employeeRepository->find($shift);
        $validated = [
            'booking_id' => $id,
            'checkin_time' => date('Y-m-d H:i:s'),
            'employee_id' => $checkinEmployee->id,
            'status' => $this->checkinRepository->getCheckinStatusFalse(),
        ];

        $this->checkinRepository->store($validated);
    }

    /**
     * Check if booking is valid
     *
     * @param  array  $bookingCollection
     * @param  int  $roomId
     * @param  Carbon  $bookingArrive
     * @param  Carbon  $bookingLeave
     * 
     * @return bool
     */
    private function isBookingValid($bookingCollection, $roomId, $bookingArrive, $bookingLeave)
    {
        foreach ($bookingCollection as $booking) {
            if ($booking['room_id'] == $roomId) {
                $arriveDate = Carbon::createFromFormat('Y-m-d', $booking['arrive_date']);
                $leaveDate = Carbon::createFromFormat('Y-m-d', $booking['leave_date']);

                if ($this->calculateAvailability($bookingArrive, $bookingLeave, $arriveDate, $leaveDate)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $validated
     * @return array
     */
    public function checkAvailability($validated)
    {
        $unavailableRoom = [];
        $bookingCollection = $this->bookingRepository->getAllBooking();

        $bookingArrive = Carbon::createFromFormat('Y-m-d', $validated['arrive_date']);
        $bookingLeave = Carbon::createFromFormat('Y-m-d', $validated['leave_date']);

        foreach ($bookingCollection as $booking) {
            $arriveDate = Carbon::createFromFormat('Y-m-d', $booking['arrive_date']);
            $leaveDate = Carbon::createFromFormat('Y-m-d', $booking['leave_date']);

            if ($this->calculateAvailability($bookingArrive, $bookingLeave, $arriveDate, $leaveDate)) {
                array_push($unavailableRoom, $booking['room_id']);
            }
        }

        $roomId = $this->roomRepository->getRoomsId()->toArray();
        $result = array_values(array_diff($roomId, $unavailableRoom));

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function cancel($id)
    {
        $result = $this->bookingRepository->update($id, ['is_cancel' => $this->bookingRepository->getIsCancelledTrue()]);

        return $result;
    }

    /**
     * Display all booking.
     *
     * @return object
     */
    public function index()
    {
        return $this->bookingRepository->index();
    }

    /**
     * Count user total booking
     *
     * @param  int  $id
     * @return int
     */
    public function countUserBooking($id)
    {
        return $this->bookingRepository->countUserBooking($id);
    }

    /**
     * Get all booking of user
     *
     * @param  int  $id
     * @return object
     */
    public function getUserBooking($id)
    {
        return $this->bookingRepository->getUserBooking($id);
    }

    /**
     * Get booking detail
     *
     * @param  int  $id
     * @return object
     */
    public function getDetail($id)
    {
        return $this->bookingRepository->getDetail($id);
    }

    /**
     * Get data for dashboard
     *
     * @return object
     */
    public function dashboard()
    {

        $guestInfos = $this->bookingRepository->guestInfo();
        $lastMonthTime = Carbon::now()->subMonth(1);
        $last7daysTime = Carbon::now()->subDays(7);
        $todayTime = Carbon::now()->toDateString();

        $today = $this->checkinRepository->countCheckinToday($todayTime);
        $last7days = $this->checkinRepository->countCheckinThisWeek($last7daysTime);

        $total = $guestInfos->sum('total_price');

        $lastMonth = $this->checkinRepository->countCheckinLastMonth($lastMonthTime);
        $lastMonthTotal = $this->checkinRepository->sumTotalLastMonth($lastMonthTime);

        $bookingInfos = [
            'today' => $today,
            'last7days' => $last7days,
            'total' => $total,
            'lastMonth' => $lastMonth,
            'lastMonthTotal' => $lastMonthTotal
        ];
        $guestAndBookingInfo = ['guestInfos' => $guestInfos, 'bookingInfos' => $bookingInfos];

        return $guestAndBookingInfo;
    }

    /**
     * Get booking each month
     *
     * @return object
     */
    public function bookingEachMonth()
    {
        $bookingEachMonth = $this->bookingRepository->bookingEachMonth();

        for ($i = 1; $i <= 12; $i++) {
            if (!$bookingEachMonth->has($i)) {
                $bookingEachMonth->put($i, 0);
            }
        }

        $bookingEachMonth = $bookingEachMonth->sortKeys();
        $bookingEachMonth = $bookingEachMonth->values();

        return $bookingEachMonth;
    }

    /**
     * Show all available room
     *
     * @param  array  $data
     * @return object
     */
    public function showAvailableRoom($data)
    {
        $result = $this->roomRepository->getRoomsById($data);

        return $result;
    }

    /**
     * Filter room by date
     *
     * @param  array  $data
     * @return object
     */
    public function filterByDate($data)
    {
        $ids = $data['roomIds'];
        $bookingArrive = Carbon::createFromFormat('Y-m-d', $data['arrive_date']);
        $bookingLeave = Carbon::createFromFormat('Y-m-d', $data['leave_date']);
        $unavailableRoom = [];

        $bookingCollection = $this->bookingRepository->getBookingByRoomsId($ids);

        foreach ($bookingCollection as $booking) {
            $arriveDate = Carbon::createFromFormat('Y-m-d', $booking['arrive_date']);
            $leaveDate = Carbon::createFromFormat('Y-m-d', $booking['leave_date']);

            if ($this->calculateAvailability($bookingArrive, $bookingLeave, $arriveDate, $leaveDate)) {
                array_push($unavailableRoom, $booking['room_id']);
            }
        }

        $availableRoom = array_values(array_diff($ids, $unavailableRoom));

        $result = $this->roomRepository->getRoomsById($availableRoom);

        return $result;
    }

    /**
     * Get guest statistic
     *
     * @return object
     */
    public function getGuestStatistic()
    {
        $guestStatistic = $this->bookingRepository->getGuestStatistic();

        return $guestStatistic;
    }

    /**
     * Caluculate availability
     *
     * @param  Carbon  $bookingArrive, $bookingLeave, $arriveDate, $leaveDate
     * @return bool
     */
    public function calculateAvailability($bookingArrive, $bookingLeave, $arriveDate, $leaveDate)
    {
        $result = $bookingArrive->between($arriveDate, $leaveDate)
            || $bookingLeave->between($arriveDate, $leaveDate)
            || $arriveDate->between($bookingArrive, $bookingLeave)
            || $leaveDate->between($bookingArrive, $bookingLeave);

        return $result;
    }
}
