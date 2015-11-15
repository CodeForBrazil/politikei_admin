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

        if (!$this->check_user(null,FALSE)) 
        {
            return $this->render('welcome/home');
        }

        $user = $this->get_currentuser();
        if($user->is(User_model::ROLE_DEFAULT))
        {
            return $this->render('welcome/aguardar');
        }

        redirect(base_url('/proposicoes/'));
    }

    public function out()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
