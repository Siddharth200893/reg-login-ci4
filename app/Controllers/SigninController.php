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
            //
            //echo $authenticatePassword;
            //echo !$authenticatePassword ? 'false' : '';
            //die();
            //$this->session->set('logo_name', $img->getName());


            $userprofile = $userModel->select('user_registration.id as registrationid, user_registration.name as name, user_registration.email as email, user_registration.phone as phone, user_details.file_name as filename')
                ->join('user_details', 'user_details.id = user_registration.id')
                ->where('user_registration.id', $data['id'])
                ->first();

            //print_r($userprofile);
            $data['userdetails'] = $userprofile;
            $userinfo = $userprofile;
            // print '<pre>';
            // print_r($userinfo['filename']);
            // print '</pre>';
            // die();

            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $userinfo['registrationid'],
                    'name' => $userinfo['name'],
                    'email' => $userinfo['email'],
                    'phone' => $userinfo['phone'],
                    'logo' => $userinfo['filename'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return view('profile');
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
        //echo $id;
        // print_r($id);
        // die();
        $editmodel = new UserModel();
        $userdata = $editmodel->select('user_registration.id as registrationid, user_registration.name as name, user_registration.email as email, user_registration.phone as phone, user_details.file_name as filename')
            ->join('user_details', 'user_details.id = user_registration.id')
            ->where('md5(user_registration.id)', $id)
            ->first();
        // )->where('md5(package.id)', $id)->first();
        // print_r($userdata);
        // die();
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
        // print_r($data);
        // die();
        $updatemodel->update($id, $updatedata);

        $updata['userdetails'] = $updatedata;

        return view('/profile', $updata);
    }
    public function logout()
    {
        session();
        session_destroy();
        return redirect()->to('/signin');
    }
}
