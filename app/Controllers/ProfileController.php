<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        // $session = session();
        // echo "Hello : " . $session->get('name') . '</br>';
        //  echo anchor('auth/logout', '[ Logout ]', 'title="Logout"') . '</br>';
        // echo "<a href=' " . base_url('/logout') . "'>Logout</a>";

        return view('profile');
    }
}
