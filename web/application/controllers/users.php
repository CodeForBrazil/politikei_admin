<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends MY_Controller
{
    protected $before_filter = array('action' => 'authorize');

    public function authorize()
    {
        $user = $this->get_currentuser();
        if(!$user || !$user->is(User_model::ROLE_ADMIN))
        {
            return redirect(base_url());   
        }
    }

    public function index()
    {
        $this->load->model('User_model');
        $users = $this->User_model->get_all();
        $this->render('users/index', ['users' => $users]);
    }

    public function autorizar($id)
    {
        $this->load->model('User_model');
        $user = $this->User_model->get_by_id($id);

        if(!$user->pode_autorizar($this->errors))
        {
            $this->session->set_flashdata('errors', $this->errors);
            return redirect(base_url('/users'));
        }

        $user->autorizar();
        $user->update();

        $this->session->set_flashdata('messages', ['Usuário autorizado com sucesso']);
        redirect(base_url('/users/index'));
    }

    public function desautorizar($id)
    {
        $this->load->model('User_model');
        $user = $this->User_model->get_by_id($id);

        if(!$user->pode_desautorizar($this->errors))
        {
            $this->session->set_flashdata('errors', $this->errors);
            return redirect(base_url('/users'));
        }

        $user->desautorizar();
        $user->update();

        $this->session->set_flashdata('messages', ['Permissão removida com sucesso']);
        redirect(base_url('/users/index'));
    }
}
