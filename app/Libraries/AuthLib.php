<?php

namespace App\Libraries;

class AuthLib
{   

    public function setUserSession($user){

        if($user){
            $data['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'group' => $user['group'],
                'email' => $user['email'],
                'isLoggedIn' => true,
            ];
            session()->set($data);
        } else {
            unset($_SESSION['user']);
        }               
        return true;
    }

    public function isLogin(){
        $session = session()->get();
        if(isset($session['user']['id'])){
            return true;
        } else{ 
            return false;
        }          
    }

    public function isAdmin(){
        $session = session()->get();
        if($session['user']['group'] === '1'){
            return true;
        } else {
            return false;
        }
    }

    public function getCode(){
        $session = session();
        if($session->get('code') == null){
            $code = rand(1000, 9999);
            $session->set('code', $code);
        }
        return true;
    }

} 