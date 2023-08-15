<?php

namespace App\Repositories;

class EmployeeRepository extends EloquentRepository
{
    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Employee::class;
    }

    /**
     * Getter for FIRST_SHIFT
     *
     * @return int
     */
    public function getFirstShift()
    {
        return $this->_model::FIRST_SHIFT;
    }

    /**
     * Getter for SECOND_SHIFT
     *
     * @return int
     */
    public function getSecondShift()
    {
        return $this->_model::SECOND_SHIFT;
    }

    /**
     * Getter for THIRD_SHIFT
     *
     * @return int
     */
    public function getThirdShift()
    {
        return $this->_model::THIRD_SHIFT;
    }

    /**
     * Getter for HOUR_SECOND_SHIFT
     *
     * @return string
     */
    public function getHourSecondShift()
    {
        return $this->_model::HOUR_SECOND_SHIFT;
    }

    /**
     * Getter for HOUR_FIRST_SHIFT
     *
     * @return string
     */
    public function getHourFirstShift()
    {
        return $this->_model::HOUR_FIRST_SHIFT;
    }

    /**
     * Getter for CHECKIN_STATUS_TRUE
     *
     * @return string
     */
    public function getCheckinStatusTrue()
    {
        return $this->_model::CHECKIN_STATUS_TRUE;
    }

    /**
     * Getter for CHECKIN_STATUS_FALSE
     *
     * @return string
     */
    public function getCheckinStatusFalse()
    {
        return $this->_model::CHECKIN_STATUS_FALSE;
    }

    /**
     * Get employee in the current shift
     *
     * @param  int  $shift
     * @return object
     */
    public function find($shift)
    {
        $result = $this->_model->where('shift', $shift)->first('id');

        return $result;
    }

    /**
     * Get employee detail
     *
     * @param  int  $id
     * @return object
     */
    public function getDetail($id)
    {
        $result = $this->_model->where('id', $id)->first(['id', 'name', 'role']);

        return $result;
    }

    /**
     * Get all employee
     *
     * @return object
     */
    public function index()
    {
        $result = $this->_model->get(['id', 'name', 'role', 'shift', 'day_off', 'salary', 'status']);

        return $result;
    }

    /**
     * Sum total salary
     *
     * @return int
     */
    public function sumSalary()
    {
        $result = $this->_model->sum('salary');

        return $result;
    }
}
