<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Libraries\Hash;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form'];

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function create(){

        $validation = $this->validate([
            'name' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'You full name is required.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                    'is_unique' => 'Email already taken.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must have atleast 5 characters in length.',
                    'max_length' => 'Password must not have characters more thant 20 in length.',
                ],
            ],
            'cpassword' => [
                'rules'  => 'matches[password]',
                'errors' => [
                    'required' => 'Confirm password is required.',
                    'min_length' => 'Confirm password must have atleast 5 characters in length.',
                    'max_length' => 'Confirm Password must not have characters more thant 20 in length.',
                    'matches' => 'Confirm Password must matches to password.',
                ],
            ],
        ]);

        if(!$validation){
          
            return  redirect()->to('auth/register')->with('validation', $this->validator)->withInput();

        }else{
            //Register user in database
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $values = [
               'name'=>$name,
               'email'=>$email,
               'password'=>Hash::make($password),
            ];

         
            $userModel = new UserModel();
            $query = $userModel->insert($values);
            if( !$query ){
                 return  redirect()->to('auth/register')->with('fail', 'Something went wrong.');
            }else{
                  return  redirect()->to('auth/register')->with('success', 'Congratilation. You are now successfully registered.');
            }
        }
    }


    public function check(){

        $validation = $this->validate([
            'email' => [
                'rules'  => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                    'is_not_unique' => 'Email not registered in our server.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must have atleast 5 characters in length.',
                    'max_length' => 'Password must not have characters more thant 20 in length.',
                ],
            ],
        ]);

        if(!$validation){
            return  redirect()->to('auth/login')->with('validation', $this->validator)->withInput();
        }else{
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $userModel = new UserModel();
            $user_info = $userModel->where('email', $email)->first();
       
            $check_password = Hash::check($password, $user_info['password']);
            if( !$check_password ){
                return  redirect()->to('auth/login')->with('fail', 'Incorect password.')->withInput();
            }else{
                $session_data = ['user' => $user_info];
                session()->set('LoggedUser', $session_data);
                return  redirect()->to('user/home');

            }
        }
    }

    public function logout(){
         if( session()->has('LoggedUser') ){
            session()->remove('LoggedUser');
            return  redirect()->to('auth/login')->with('fail', 'You are now logged out.');
         }
    }
}