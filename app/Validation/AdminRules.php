<?php

namespace App\Validation;
use App\Models\Admin\AuthModel;

class AdminRules{
    public function validateAdmin(string $str, string $fields, array $data){
        $model = new AuthModel();
        $user = $model->where('phone', $data['phone'])
            ->first();

        if(!$user)
            return false;

        return password_verify($data['password'], $user['password']);
    }

    public function updateAdmin(string $str, string $fields, array $data)
    {
        $model = new AuthModel();
        $session_user = session()->get('user');
        $user = $model->where('id', $session_user['id'])
            ->first();

        if(!$user)
            return false;

            return password_verify($data['password'], $user['password']);

    }

}