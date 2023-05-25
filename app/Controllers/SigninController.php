<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\UserDetailsModel;
use CodeIgniter\I18n\Time;

class SigninController extends Controller
{
    public function index()
    {
        helper(['form']);
        echo view('signin');
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $userModel->where('email', $email)->first();
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);

            if ($authenticatePassword) {
                $userprofile = $userModel->select('user_registration.id as registrationid, user_registration.name as name, user_registration.email as email, user_registration.phone as phone, user_details.file_name as filename')
                    ->join('user_details', 'user_details.id = user_registration.id')
                    ->where('user_registration.id', $data['id'])
                    ->first();

                // $data['userdetails'] = $userprofile;
                $userinfo = $userprofile;

                $ses_data = [
                    'id' => $userinfo['registrationid'],
                    'name' => $userinfo['name'],
                    'email' => $userinfo['email'],
                    'phone' => $userinfo['phone'],
                    'photo' => $userinfo['filename'],
                    'isLoggedIn' => true
                ];
                $session->set($ses_data);
                $data['userdetails'] = $userprofile; // Add this line to pass the data to the view
                return view('profile', $data);

                return redirect()->to('/profile');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/signin');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/signin');
        }
    }

    public function edit_profile($id)
    {
        $editmodel = new UserModel();
        $userdata = $editmodel->select('user_registration.id as registrationid, user_registration.name as name, user_registration.email as email, user_registration.phone as phone, user_details.file_name as filename')
            ->join('user_details', 'user_details.id = user_registration.id')
            ->where('md5(user_registration.id)', $id)
            ->first();

        $data['userdetails'] = $userdata;
        return view('edit_profile', $data);
    }

    public function update_profile()
    {
        $session = session();
        $myTime = new Time('now');
        helper(['form']);
        $updatemodel = new UserModel();
        $id = $this->request->getVar('id');
        $updatedata = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'modified_at' => $myTime,
        ];

        $updatemodel->update($id, $updatedata);

        // Fetch the updated user details
        $userdetails = $updatemodel->select('user_registration.id as registrationid, user_registration.name as name, user_registration.email as email, user_registration.phone as phone, user_details.file_name as filename')
            ->join('user_details', 'user_details.id = user_registration.id')
            ->where('user_registration.id', $id)
            ->first();

        $data['userdetails'] = $userdetails;

        return view('profile', $data);
    }


    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/signin');
    }
}
