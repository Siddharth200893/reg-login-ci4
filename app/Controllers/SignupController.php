<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class SignupController extends Controller
{
    public function reg_form()
    {
        helper(['form']);
        $data = [];
        echo view('signup', $data);
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'name'          => 'required',
            'l_name'         => 'required',
            'photo'         => 'required',
            'email'      => 'required',
            'password'  => 'required',
            'phone'          => 'required',
            'message'         => 'required',

        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data = [
                'name'     => $this->request->getVar('name'),
                'l_name'    => $this->request->getVar('l_name'),
                'photo'    => $this->request->getVar('photo'),
                'email' => $this->request->getVar('email'),
                'password'     => $this->request->getVar('password'),
                'phone'    => $this->request->getVar('phone'),
                'message' => $this->request->getVar('message'),


            ];
            $userModel->save($data);
            return redirect()->to('/signin');
        } else {
            $data['validation'] = $this->validator;
            echo view('signup', $data);
        }
    }
}
