<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use App\Repositories\CheckinRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\RoomRepository;

class CheckinService
{
    private $checkinRepository;

    private $bookingRepository;

    private $roomRepository;

    private $employeeRepository;

    public function __construct(CheckinRepository $checkinRepository, BookingRepository $bookingRepository, RoomRepository $roomRepository, EmployeeRepository $employeeRepository)
    {
        $this->checkinRepository = $checkinRepository;
        $this->bookingRepository = $bookingRepository;
        $this->roomRepository = $roomRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Display all checkin
     *
     * @return object
     */
    public function index()
    {
        $result = $this->checkinRepository->index();

        return $result;
    }

    /**
     * Checkout checkin
     *
     * @param  int  $id, $booking_id
     * @return bool
     */
    public function checkout($id, $booking_id)
    {
        $roomId = $this->bookingRepository->getRoomId($booking_id)['room_id'];
        $this->roomRepository->update($roomId, ['status' => false]);

        $price = $this->roomRepository->getPrice($roomId);
        $hourPrice = $price->hour_price;
        $dayPrice = $price->day_price;

        $this->checkinRepository->update($id, ['checkout_time' => date('Y-m-d H:i:s')]);

        $fee = $this->checkinRepository->find($id)->fee;
        $checkinTime = $this->checkinRepository->find($id)->checkin_time;

        $diffHour = now()->diffInHours($checkinTime);
        $diffDay = now()->diffInDays($checkinTime);

        $inDay = $diffDay == $this->checkinRepository->getDiffLessThan1();
        $total = ($diffHour == $this->checkinRepository->getDiffLessThan1() && $inDay)
            ? ($hourPrice + $fee)
            : (($diffHour < $this->checkinRepository->getFirst3Hour() && $inDay)
                ? ($diffHour * $hourPrice + $fee)
                : (($diffHour > $this->checkinRepository->getFirst3Hour() && $inDay)
                    ? ($dayPrice + $fee)
                    : ($dayPrice * $diffDay + $fee)));

        $result = $this->checkinRepository->update($id, ['total_price' => $total]);

        return $result;
    }

    /**
     * Destroy a checkin
     *
     * @param  int  $id
     * @return bool
     */
    public function remove($id)
    {
        $result = $this->checkinRepository->update($id, ['status' => $this->checkinRepository->getCheckinStatusTrue()]);

        return $result;
    }

    /**
     * Update fee
     *
     * @param  int  $id, $fee
     * @return bool
     */
    public function updateFee($id, $fee)
    {
        $result = $this->checkinRepository->update($id, ['fee' => $fee]);

        return $result;
    }

    /**
     * Get checkin today
     *
     * @return object
     */
    public function getCheckinToday()
    {
        $result = $this->checkinRepository->getCheckinToday();

        return $result;
    }

    /**
     * Get interest each month
     *
     * @return object
     */
    public function interestEachMonth()
    {
        $interestEachMonth = $this->checkinRepository->interestEachMonth();

        for ($i = 1; $i <= 12; $i++) {
            if (!$interestEachMonth->has($i)) {
                $interestEachMonth->put($i, config('constants.DEFAULT_INTEREST'));
            }
        }

        $interestEachMonth = $interestEachMonth->sortKeys();
        $interestEachMonth = $interestEachMonth->values();

        return $interestEachMonth;
    }

    /**
     * Calculate income after expenses
     *
     * @return object
     */
    public function incomeAfterExpense()
    {
        $tax = config('constants.TAX_RATE');
        $utilities = config('constants.UTILITIES');
        $interestThisMonth = $this->checkinRepository->interestThisMonth();
        $salary = $this->employeeRepository->sumSalary();
        $interestAndSalary = [$interestThisMonth - $salary - $interestThisMonth * $tax, $salary, $utilities, $interestThisMonth * $tax];

        return $interestAndSalary;
    }

    /**
     * Get checkin detail
     *
     * @param  int  $bookingId, $checkinId
     * 
     * @return object
     */
    public function getDetail($bookingId, $checkinId)
    {
        $employeeId = $this->checkinRepository->getEmployeeId($checkinId)['employee_id'];

        $bookingDetail = $this->bookingRepository->getDetail($bookingId);
        $employeeDetail = $this->employeeRepository->getDetail($employeeId);

        $result[0] = $bookingDetail;
        $result[1] = $employeeDetail;

        return $result;
    }
}
