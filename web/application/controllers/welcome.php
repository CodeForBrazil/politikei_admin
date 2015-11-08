<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Welcome extends MY_Controller
{
    public function index()
    {
        if (isset($_GET['from'])) {
            $this->set_data('open_modal', 'login');
        }

        if (!$this->check_user(null,FALSE)) {
            $this->load->view('welcome/home', $this->get_data());
            return;
        }

       //redirect(base_url('/proposicoes'));
    }

    public function out()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
