<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BusinessModel;
use CodeIgniter\I18n\Time;

class BusinessController extends Controller
{
    public function business_form()

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

            $id = $this->request->getVar('user_id');

            $businessData = [
                'user_id' => $this->request->getVar('user_id'),
                'name' => $this->request->getVar('name'),
                'address' => $this->request->getVar('address'),
                'phone' => $this->request->getVar('phone'),
                'email' => $this->request->getVar('email'),
                'l_img_name' => $img->getName(),
                'l_img_type' => $img->getClientMimeType(),
                'g_img_name' => json_encode($galleryData)
            ];
            // print_r($businessData);
            // die();
            $businessModel->insert($businessData);


            $data['business'] = $businessModel->where('user_id', $id)->orderBy("created_at", "desc")->findAll();
            return view('view_business', $data);



            // $msg = 'Data has been successfully uploaded';
            // return view('view_business', ['business' => $businessData, 'msg' => $msg]);
            //return redirect()->to(base_url('/add-business'))->with('msg', $msg);
        }
    }

    public function business_list($id)

    {
        $model = new BusinessModel();
        helper(['form']);

        $data['business'] = $model->where('md5(user_id)', $id)->orderBy("created_at", "desc")->findAll();
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

    public function update_business($id)
    {
        //$session = session();
        $myTime = new Time('now');
        helper(['form']);
        $updatemodel = new BusinessModel();
        $business = $updatemodel->where('md5(id)', $id)->first();
        //$id = $this->request->getVar('id');

        // print_r($id);
        // die();
        $updatedata = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'file_name' => $this->request->getVar('file_name'),
            'modified_at' => $myTime,
        ];
        // print_r($data);
        // die();
        $updatemodel->update($id, $updatedata);


        $removeGalleryImages = $this->request->getPost('remove_gallery_images');

        // print_r($removeGalleryImages);
        // die();

        if ($removeGalleryImages) {
            //$removedImages = json_decode($business['g_img_name'], true);
            foreach ($removeGalleryImages as $image) {


                // Remove the image from the server
                $path =   unlink(WRITEPATH . '../public/gallery/' . $image);
                print_r($path);
                die();
                // Remove the image from the removed images array
                // $removedImages = array_filter($removedImages, function ($img) use ($image) {
                //     return $img['g_img_name'] !== $image;
                // });
            }

            // Update the gallery images data without the removed images
            //$updategalleryData['g_img_name'] = json_encode($removedImages);
        }


        //$updatemodel->update($id, $updategalleryData);


        // }




        // $picture = $this->request->getFile('file_name');
        // if ($picture->isValid() && !$picture->hasMoved()) {
        //     $newName = $picture->getRandomName();
        //     $picture->move(ROOTPATH . 'public/uploads', $newName);
        //     $userDetailsModel = new UserDetailsModel();
        //     $userDetailsModel->update($id, ['file_name' => $newName]);
        // }

        // $updatemodel->update($id, $updatedata);
        //below join used for only file name
        // $userdetails = $updatemodel->select('user_registration.id as registrationid, user_registration.name as name, user_registration.email as email, user_registration.phone as phone, user_details.file_name as filename')
        //     ->join('user_details', 'user_details.id = user_registration.id')
        //     ->where('user_registration.id', $id)
        //     ->first();

        // $data['userdetails'] = $userdetails;

        $msg = 'Business details have been updated successfully.';
        return redirect()->to(base_url('view-business/' . md5($id)))->with('msg', $msg);
        //return view('view_business_details');
    }
}
