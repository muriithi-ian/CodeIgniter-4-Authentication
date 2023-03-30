<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
  
    public function index(){
        $data = [
           'pageTitle'=>'Dashboard | Home',
           'userInfo'=> session()->get('LoggedUser')
        ];
         return view('dashboard/home', $data);
    }

}