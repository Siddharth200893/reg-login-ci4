<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BusinessModel;

class BusinessController extends Controller
{
    public function business()

    {
        helper(['form']);
        return view('add_business');
    }

    public function add_business()
    {
        helper(['form', 'url']);

        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'logo' => [
                'uploaded[logo]',
                'mime_in[logo,image/jpg,image/jpeg,image/png]',
                'max_size[logo,1024]',
            ],
        ];

        if ($this->validate($rules)) {
            $businessModel = new BusinessModel();
            $img = $this->request->getFile('logo');
            $img->move(WRITEPATH . '../public/logo');

            $galleryImages = $this->request->getFileMultiple('gallery_images');
            $galleryData = [];

            if ($galleryImages) {
                foreach ($galleryImages as $file) {
                    $file->move(WRITEPATH . '../public/gallery');
                    $galleryData[] = [
                        'g_img_name' => $file->getClientName(),
                        'g_img_type' => $file->getClientMimeType(),
                    ];
                }
            }

            $businessData = [
                'name' => $this->request->getVar('name'),
                'address' => $this->request->getVar('address'),
                'phone' => $this->request->getVar('phone'),
                'email' => $this->request->getVar('email'),
                'l_img_name' => $img->getName(),
                'l_img_type' => $img->getClientMimeType(),
                'g_img_name' => json_encode($galleryData)
            ];

            $businessModel->insert($businessData);

            $msg = 'Data has been successfully uploaded';
            return view('view_business', ['business' => $businessData, 'msg' => $msg]);
            //return redirect()->to(base_url('/add-business'))->with('msg', $msg);
        }
    }

    public function business_list($id)

    {
        $model = new BusinessModel();
        helper(['form']);

        $data['business'] = $model->where('md5(id)', $id)->first();
        return view('view_business', $data);
    }

    public function view_business_details($id)
    {
        // print_r($id);
        // die();
        $model = new BusinessModel();
        helper(['form']);

        $data['business'] = $model->where('md5(id)', $id)->first();
        return view('view_business_details', $data);
    }

    public function edit_business_details($id)
    {
        $editmodel = new BusinessModel();

        $data['business'] = $editmodel->where('md5(id)', $id)->first();
        return view('edit_business_details', $data);
    }
}
