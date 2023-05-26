<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ContactUsModel;
use App\Models\BusinessAddRequestModel;
use App\Models\BusinessClaimsModel;
use App\Models\ManagerDownloadsModel;
use App\Models\CategorySeoModel;
use App\Models\BussinessesModel;
use App\Models\SubCategorySeoModel;
use App\Models\SubCategoryModel;
use App\Models\DistrictsModel;
use App\Models\FeatureModel;
use App\Models\NeabyLocationModel;
use App\Models\ReviewsModel;
use App\Models\PackageModel;
use App\Models\PackageSalesModel;
use App\Models\PackageDetailsModel;
use CodeIgniter\I18n\Time;

class ManagerController extends BaseController
{
	public function managerLoggedIn()
	{
		$session = session();
		if (session()->get('role') == "4") {
			return 1;
		} else {
			return 0;
		}
	}
	public function logout()
	{
		$session = session();
		$session->destroy();
		return redirect()->to(base_url() . '/manager/login');
	}
	public function login()
	{
		return view('manager/login');
	}
	public function manager_login()
	{
		$usersModel = new UsersModel();
		$session = session();
		$email = $this->request->getvar('email');
		$pass = $this->request->getvar('password');
		$get_data = $usersModel->login($email, $pass);
		if ($get_data) {
			$role = $get_data[0]->role;
			if ($role == "4") {
				$session->set("Email", $get_data[0]->email);
				$session->set("name", $get_data[0]->name);
				$session->set("role", $get_data[0]->role);
				$session->set("logged_in", TRUE);
				$session->set("userid", $get_data[0]->id);
				$session->set("logged_in_type", "manager");
				return redirect()->to(base_url() . '/manager/dashboard');
			} else {
				$session->setFlashdata('error_login', 'You are not authorised to login here');
				return redirect()->to(base_url() . '/manager/login');
			}
		} else {
			$session->setFlashdata('error_login', 'Invalid username/password');
			return redirect()->to(base_url() . '/manager/login');
		}
	}
	public function manager_dashboard($login_id = null)
	{
		if ($this->managerLoggedIn()) {
			$session = \Config\Services::session();
			$role = $session->get('role');
			if ($session->get('role') == "4") {
				$login_id = $session->get('userid');
				$contactUsModel = new ContactUsModel();
				$contact_enquires = $contactUsModel->contact_enquiries();
				$data = [
					'login_id' => $login_id,
					'contact_enquires' => $contact_enquires,
					'role' => $role,
					'dashboard_sidebar' => "active",
				];
				return view('manager/dashboard', $data);
			} else {
				return redirect()->to(base_url() . '/manager/login');
			}
		} else {
			return redirect()->to(base_url() . '/manager/login');
		}
	}
	public function contact_queries()
	{
		if ($this->managerLoggedIn()) {
			$contactUsModel = new ContactUsModel();
			$contact_enquires = $contactUsModel->contact_enquiries();
			$data = [
				'contact_enquires' => $contact_enquires,
				'contact_enquiry_sidebar' => "active",
			];
			return view('manager/contact-queries', $data);
		} else {
			return redirect()->to(base_url() . '/manager/login');
		}
	}
	public function business_add_request()
	{
		if ($this->managerLoggedIn()) {
			$businessAddRequestModel = new BusinessAddRequestModel();
			$business_add_request = $businessAddRequestModel->addBusinessRequests();
			$data = [
				'business_add_requests' => $business_add_request,
				'business_add_request_sidebar' => "active",
			];
			return view('manager/business-add-request', $data);
		} else {
			return redirect()->to(base_url() . '/manager/login');
		}
	}
	public function business_claim_enquiries()
	{
		if ($this->managerLoggedIn()) {
			$businessClaimsModel = new BusinessClaimsModel();
			$business_claim_enquiries = $businessClaimsModel->business_claim_enquiries();
			$data = [
				'business_claim_enquiries' => $business_claim_enquiries,
				'business_claim_enquiries_sidebar' => "active",
			];
			return view('manager/business-claim-enquiries', $data);
		} else {
			return redirect()->to(base_url() . '/manager/login');
		}
	}
	public function download_contact_enquires($pass = null, $from = null, $to = null)
	{
		if ($pass != getenv('DOWNLOAD_ENTRIES_PASS')) {
			echo "0";
			die();
		} else {
			$session = session();
			$managerDownloadsModel = new ManagerDownloadsModel();
			$managerDownloads = $managerDownloadsModel->where('user_id', $session->get('userid'))->findAll();
			helper(['dubaiFunction']);
			$blockedIps = array("103.223.11.28", "103.61.73.2");
			$ip = $this->request->getIPAddress();
			$data_array = [
				'user_id' => $session->get('userid'),
				'type'    => 0,
				'times'    => 1,
				'ip'    => ip2long($ip),
				'created_at' => date('Y-m-d H:s:a'),
			];
			$managerDownloadsModel->save_manager_downloads($data_array);
			/* if (is_array($managerDownloads) && count($managerDownloads) == 0) {
				
			} else {
				$data_array = [
					'user_id' => $session->get('userid'),
					'type'    => 0,
					'times'    => $managerDownloads[0]['times'] + 1,
					'ip'    => ip2long($ip),
					'updated_at' => date('Y-m-d H:s:a'),
				];
				$managerDownloadsModel->save_manager_downloads($data_array);
			} */
			function convert_date($input_date)
			{
				// Remove time zone information from the string so that it can be parsed
				$index = strpos($input_date, "GMT");
				$datePicker = substr($input_date, 0, $index - 1);
				$datePHP = strtotime($datePicker);
				$date = date('Y-m-d', $datePHP);
				return $date;
			}
			$from_date = convert_date($from);
			$to_date = convert_date($to);
			$contactUsModel = new ContactUsModel();
			if ($from != 'null' && $to != "null") {
				$contactUsData = $contactUsModel->download_contact_entries($from_date, $to_date);
			} else
				$contactUsData = $contactUsModel->download_contact_entries();
			// file name
			$filename = 'contact_enquires' . date('YmdHis') . '.csv';
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$filename");
			header("Content-Type: application/csv; ");
			header("Content-Type: application/download");
			// file creation
			$file = fopen('php://output', 'w');
			$header = array("Name", "Business", "Email", "Company", "Phone", "Message");
			fputcsv($file, $header);
			foreach ($contactUsData as $key => $line) {
				fputcsv($file, array_map(function ($v) {
					//adding "\r" at the end of each field to force it as text
					return $v . "\r";
				}, $line));
			}
			fclose($file);
			exit;
		}
	}
	public function approved_business()
	{
		if ($this->managerLoggedIn()) {
			$session = session();
			$managerDownloadsModel = new ManagerDownloadsModel();
			$managerDownloadsCount = $managerDownloadsModel->where('user_id', $session->get('userid'))->where('type', "1")->findAll();
			$data = [
				'managerDownloadsCount' => $managerDownloadsCount,
				'approved_business_sidebar' => "active",
			];
			return view('manager/approved-business', $data);
		} else {
			return redirect()->to(base_url() . '/manager/login');
		}
	}
	public function download_business_approved($pass = null, $from = null, $to = null)
	{
		if ($pass != getenv('DOWNLOAD_ENTRIES_PASS')) {
			echo "0";
			die();
		} else {
			$download =  $this->request->getVar('download');
			if ($download == "no") {
				function convert_date_time($input_date)
				{
					// Remove time zone information from the string so that it can be parsed
					$index = strpos($input_date, "GMT");
					$datePicker = substr($input_date, 0, $index - 1);
					$datePHP = strtotime($datePicker);
					$date = date('Y-m-d', $datePHP);
					return $date;
				}
				$session = session();
				$managerDownloadsModel = new ManagerDownloadsModel();
				helper(['dubaiFunction']);
				$blockedIps = array("103.223.11.28", "103.61.73.2");
				$ip = $this->request->getIPAddress();
				$data_array = [
					'user_id' => $session->get('userid'),
					'from_date'    => convert_date_time($from),
					'to_date'    => convert_date_time($to),
					'type'    => 1,
					'ip'    => ip2long($ip),
					'created_at' => date('Y-m-d H:s:a'),
					'updated_at' => date('Y-m-d H:s:a'),
				];
				$managerDownloadsModel->save_manager_downloads($data_array);
				echo "1";
			} else {
				function convert_date($input_date)
				{
					// Remove time zone information from the string so that it can be parsed
					$index = strpos($input_date, "GMT");
					$datePicker = substr($input_date, 0, $index - 1);
					$datePHP = strtotime($datePicker);
					$date = date('Y-m-d', $datePHP);
					return $date;
				}
				$from_date = convert_date($from);
				$to_date = convert_date($to);
				$bussinessesModel = new BussinessesModel();
				if ($from != 'null' && $to != "null") {
					$bussinessData = $bussinessesModel->download_business_approved($from_date, $to_date);
					$filename = 'business_approved_' . $from_date . '_' . $to_date . '.csv';
				} else {
					$bussinessData = $bussinessesModel->download_business_approved();
					$filename = 'business_approved_' . date('YmdHis') . '.csv';
				}
				/* print("<pre>" . print_r($bussinessData, true) . "</pre>");
				die(); */
				// file name
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=$filename");
				header("Content-Type: application/csv; ");
				header("Content-Type: application/download");
				// file creation
				$file = fopen('php://output', 'w');
				$header = array("Business Name", "Email", "URL");
				fputcsv($file, $header);
				foreach ($bussinessData as $key => $line) {
					fputcsv($file, array_map(function ($v) {
						//adding "\r" at the end of each field to force it as text
						return $v . "\r";
					}, $line));
				}
				fclose($file);
				exit;
			}
		}
	}
	// ......package-section......
	public function package()
	{
		return view('manager/package/package');
	}
	public function add_package()
	{
		// Load the form helper
		helper('form');
		// Load the ContactModel
		$packagemodel = new PackageModel();
		// If the form is submitted
		if ($this->request->getMethod() === 'post') {
			// Validate the form data
			$rules = [
				'name' => 'required',
				'duration' => 'required',
				'shortname' => 'required',
				'price' => 'required',
				'startdate' => 'required',
				'enddate' => 'required',
			];
			if ($this->validate($rules)) {
				// Insert the form data into the database
				$packagemodel->insert([
					'name' => $this->request->getPost('name'),
					'duration' => $this->request->getPost('duration'),
					'shortname' => $this->request->getPost('shortname'),
					'price' => $this->request->getPost('price'),
					'startdate' => $this->request->getPost('startdate'),
					'enddate' => $this->request->getPost('enddate'),
					// 'package_id' => $packagemodel->insertid(),
				]);
				// $insert_id = $this->$packagemodel->insertid(); //getting insert id 
				$insert_id = $packagemodel->insertId();

				$packagedetailsmodel = new PackageDetailsModel();
				$names = $this->request->getPost('attraction');
				$desc = $this->request->getPost('content');
				$name_objects = [];
				foreach ($names as $name) {
					$name_objects[] = ['name' => $name];
				}
				$json_names = json_encode($name_objects);
				// $json_names = json_encode($names);
				// $attractions = $this->request->getPost('attraction[]');
				// $data = [];
				$packagedetailsmodel->insert([
					'package_id' => $insert_id, // Add the ID value to the array
					'attractions' => $json_names,
					'description' => $desc,
				]);

				return redirect()->back()->with('success_save', 'Form submitted successfully!');
			} else {
				// If validation fails, display the form with errors
				// echo view('contact_form', [
				// 	'validation' => $this->validator,
				// ]);
				return view('manager/package/package');
			}
		}
		// Display the form
		//echo view('contact_form');
	}

	public function listing_packagedetails($id)
	{
		$PackageDetailsModel = new PackageDetailsModel();
		$data['package_details'] = $PackageDetailsModel->where('md5(id)', $id)->orderBy('id', 'DESC')->findAll();
		return view('manager/package/package-details', $data);
	}

	public function edit_packagedetails($id)
	{
		helper(['form']);
		$model = new PackageModel();
		/* echo $id;
		die(); */
		$pkgData = $model->select('package.id as packageid , package.duration as duration, package.shortname as shortname, package.price as price,  package.name as packagename, package_details.attractions as inputattractions, package_details.description as description, package.status as status')->join(
			'package_details',
			'package_details.package_id = package.id'
		)->where('md5(package.id)', $id)->first();
		// print_r($pkgData);
		// die();
		$data['packagedata'] = $pkgData;

		return view('manager/package/edit-package', $data);
	}

	public function update_package()
	{
		//$myTime = new DateTime('now');

		// print_r($myTime);
		// die();
		$myTime = new Time('now');
		helper(['form']);
		$updatemodel = new PackageModel();
		$id = $this->request->getVar('packageid');
		$data = [
			'name' => $this->request->getVar('name'),
			'duration' => $this->request->getVar('duration'),
			'shortname' => $this->request->getVar('shortname'),
			'status' => $this->request->getVar('status_btn'),
			'price' => $this->request->getVar('price'),
			'modified_at' => $myTime,

		];
		// print_r($data);
		// die();
		$updatemodel->update($id, $data);

		helper(['form']);
		$updatemodel2 = new PackageDetailsModel();

		$id2 = $this->request->getVar('packageid');
		$names2 = $this->request->getPost('attraction');

		$name_objects2 = [];
		foreach ($names2 as $name2) {
			$name_objects2[] = ['name' => $name2];
		}
		$json_names2 = json_encode($name_objects2);



		$data2 = [
			'attractions' => $json_names2,
			'description' => $this->request->getVar('content'),
			'updated_at' => $myTime,


		];
		// print_r($data);
		// die();
		$updatemodel2->update($id2, $data2);
		return $this->response->redirect(base_url('manager/package-list'));
		//return view('manager/package/package-list');
	}

	public function listing()
	{
		$modellisting = new PackageModel();
		$data = [
			'users' => $modellisting->paginate(4),
			'pager' => $modellisting->pager
		];
		// $data['packages'] = $modellisting->orderBy('id', 'DESC')->findAll();
		return view('manager/package/package-list', $data);
	}
	public function sales_list()
	{
		$PackageSalesModel = new \App\Models\PackageSalesModel();
		$data['fetched_sales'] = $PackageSalesModel->paginateNews(1);
		$data['pager'] = $PackageSalesModel->pager;
		$data['links'] = $data['pager']->links();
		return view('manager/package/sales-list', $data);
	}
}
