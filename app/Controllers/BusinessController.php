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



            $msg = 'You have added the business successfully.';
            session()->setFlashdata('msg', $msg);
            return view('add_business');
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


    public function update_business()
    {
        $myTime = new Time('now');
        helper(['form']);
        $model = new BusinessModel();
        $id = $this->request->getVar('id');
        $business = $model->where('id', $id)->first();


        $logo = $this->request->getFile('logo');

        // Check if a new logo was uploaded
        if ($logo->isValid()) {
            // Generate a unique name for the logo file
            $newLogoName = $logo->getRandomName();

            // Move the uploaded logo file to the desired directory
            $logo->move('./public/logo', $newLogoName);

            // Update the logo file name in the database
            $updatedata['l_img_name'] = $newLogoName;

            // Remove the old logo file from the server
            if ($business['l_img_name']) {
                $oldLogoPath = './public/logo/' . $business['l_img_name'];
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }
        }

        $model->update($id, $updatedata);

        $updatedata = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'modified_at' => $myTime,
        ];

        $model->update($id, $updatedata);

        $removeGalleryImages = $this->request->getPost('remove_gallery_images');
        if ($removeGalleryImages) {
            $removedImages = json_decode($business['g_img_name'], true);

            foreach ($removeGalleryImages as $image) {
                // Remove the image from the server
                $filePath = WRITEPATH . '../public/gallery/' . $image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                // Remove the image name from the removed images array
                $removedImages = array_filter($removedImages, function ($img) use ($image) {
                    return $img['g_img_name'] !== $image;
                });
            }

            // Update the gallery images data without the removed images
            $updategallerydata['g_img_name'] = json_encode(array_values($removedImages));
        } else {
            // If no images are removed, keep the existing gallery images data
            $updategallerydata['g_img_name'] = $business['g_img_name'];
        }

        // Handle the new gallery images
        $newGalleryImages = $this->request->getFiles()['gallery_images'];
        if ($newGalleryImages) {
            $uploadedImages = [];
            foreach ($newGalleryImages as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newImageName = $file->getRandomName();
                    $file->move(WRITEPATH . '../public/gallery/', $newImageName);
                    $uploadedImages[] = [
                        'g_img_name' => $newImageName,
                    ];
                }
            }

            // Merge the new uploaded images with the existing gallery images
            $galleryImages = json_decode($updategallerydata['g_img_name'], true);
            $galleryImages = array_merge($galleryImages, $uploadedImages);

            // Update the gallery images data with the merged images
            $updategallerydata['g_img_name'] = json_encode($galleryImages);
        }

        // If all images are removed, set the g_img_name field to NULL
        if (empty($removedImages)) {
            $updatedata['g_img_name'] = null;
        }

        $model->update($id, $updatedata);
        $model->update($id, $updategallerydata);

        $msg = 'Business details have been updated successfully.';
        return redirect()->to(base_url('view-business/' . md5($id)))->with('msg', $msg);
    }
}
