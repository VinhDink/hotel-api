<?php

namespace App\Repositories;

class UserRepository extends EloquentRepository
{
    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }

    /**
     * Find the user by id
     *
     * @param  int  $id
     * @return object
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Get all user
     *
     * @return object
     */
    public function index()
    {
        $result = $this->_model->get(['id', 'username', 'email', 'role']);

        return $result;
    }

    /**
     * Find user by email
     *
     * @param  string  $email
     * @return object
     */
    public function findByEmail($email)
    {
        $result = $this->_model->where('email', $email)->first();

        return $result;
    }
}
