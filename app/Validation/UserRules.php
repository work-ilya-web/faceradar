<?php

namespace App\Validation;
use App\Models\UserModel;

class UserRules{
    public function validateUser(string $str, string $fields, array $data){
        $model = new UserModel();
        $user = $model->where('phone', $data['phone'])
            ->first();

        if(!$user)
            return false;

        return password_verify($data['password'], $user['password']);
    }
    public function updateUser(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $session_user = session()->get('user');
        $user = $model->where('id', $session_user['id'])
            ->first();

        if(!$user)
            return false;

            return password_verify($data['password'], $user['password']);

    }

}