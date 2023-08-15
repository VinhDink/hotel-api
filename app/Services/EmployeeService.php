<?php

namespace App\Services;

use App\Repositories\CheckinRepository;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
    private $employeeRepository;

    private $checkinRepository;

    public function __construct(EmployeeRepository $employeeRepository, CheckinRepository $checkinRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->checkinRepository = $checkinRepository;
    }

    /**
     * Get employee detail
     *
     * @param  int  $id
     * @return object
     */
    public function getDetail($id)
    {
        $employeeId = $this->checkinRepository->getEmployeeId($id);

        return $this->employeeRepository->getDetail($employeeId);
    }

    /**
     * Get all employee
     *
     * @return object
     */
    public function index()
    {
        $hour = date('H');
        $employees = $this->employeeRepository->index();
        foreach ($employees as $employee) {
            switch ($employee['shift']) {
                case 1:
                    $status = ($hour <= $this->employeeRepository->getHourFirstShift())
                        ? 'Active'
                        : 'Inactive';
                    $employee['status'] = $status;
                    break;
                case 2:
                    $status = ($hour <= $this->employeeRepository->getHourSecondShift() && 
                    $hour >= $this->employeeRepository->getHourFirstShift()) ? 'Active'
                        : 'Inactive';
                    $employee['status'] = $status;
                    break;
                case 3:
                    $status = ($hour > $this->employeeRepository->getHourSecondShift()) ? 'Active'
                        : 'Inactive';
                    $employee['status'] = $status;
                    break;
            }
        }

        return $employees;
    }
}
