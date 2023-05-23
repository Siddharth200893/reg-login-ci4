<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\UserDetailsModel;

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
        helper(['form', 'url']);
        $rules = [
            'name'          => 'required',
            'l_name'         => 'required',
            'photo' => [
                'uploaded[photo]',
                'mime_in[photo,image/jpg,image/jpeg,image/png]',
                'max_size[photo,1024]',
            ],
            'email'      => 'required',
            'password'  => 'required',
            'phone'          => 'required',
            'message'         => 'required',
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $img = $this->request->getFile('photo');
            $img->move(WRITEPATH . '../public/uploads');

            $userModel->insert([
                'name'     => $this->request->getVar('name'),
                'l_name'    => $this->request->getVar('l_name'),
                'email' => $this->request->getVar('email'),
                'password'     => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'phone'    => $this->request->getVar('phone'),
            ]);

            $userdetailsModel = new UserDetailsModel();
            $userdetailsModel->insert([

                'message' => $this->request->getVar('message'),
                'file_name' =>  $img->getName(),
                'file_type'  => $img->getClientMimeType(),
            ]);


            //$userModel->save($data);
            return redirect()->to('/signin');
        } else {
            $data['validation'] = $this->validator;
            echo view('signup', $data);
        }
    }
}
