<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Base controller with auth check.
 */
class MY_Controller extends CI_Controller
{

    /**
     * Data to send to view.
     *
     * @var array
     */
    private $_data = array();
    public $debug = array();
    public $messages = array();
    public $errors = array();

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initialize_lang();

        $user_id = $this->session->userdata('user_id');
        if (!empty($user_id)) {
            $this->load->model('User_model');
            $this->set_data('current_user', $this->User_model->get_by_id($user_id));
        }
        $this->output->set_header('Content-Type: text/html; charset=' . $this->config->item('charset'));

        $this->check_post();
    }

    //https://github.com/machuga/codeigniter-filter/blob/master/core/MY_Controller.php
    protected $before_filter   = array(
        // Example
        // 'action'    => 'redirect_if_not_logged_in',
    );
    protected $after_filter    = array();


    // Utilize _remap to call the filters at respective times
    public function _remap($method, $params = array())
    {
        $this->before_filter();
        if (method_exists($this, $method))
        {
            empty($params) ? $this->{$method}() : call_user_func_array(array($this, $method), $params);
        }
        $this->after_filter();
    }
    // Allows for before_filter and after_filter to be called without aliases
    public function __call($method, $args)
    {
        if (in_array($method, array('before_filter', 'after_filter')))
        {
            if (isset($this->{$method}) && ! empty($this->{$method}))
            {
                $this->filter($method, isset($args[0]) ? $args[0] : $args);
            }
        }
        else
        {
            log_message('error', "Call to nonexistent method ".get_called_class()."::{$method}");
            return false;
        }
    }

    // Begins processing filters
    protected function filter($filter_type, $params)
    {
        $called_action = $this->router->fetch_method();
        if ($this->multiple_filter_actions($filter_type))
        {
            foreach ($this->{$filter_type} as $filter)
            {
                $this->run_filter($filter, $called_action, $params);
            }
        }
        else
        {
            $this->run_filter($this->{$filter_type}, $called_action, $params);
        }
    }

    // Determines if the filter method can be called and calls the requested 
    // action if so, otherwise returns false
    protected function run_filter(array &$filter, $called_action, $params)
    {
        if (method_exists($this, $filter['action']))
        {
            // Set flags
            $only = isset($filter['only']);
            $except = isset($filter['except']);
            if ($only && $except) 
            {
                log_message('error', "Only and Except are not allowed to be set simultaneously for action ({$filter['action']} on ".$this->router->fetch_method().".)");
                return false;
            }
            elseif ($only && in_array($called_action, $filter['only'])) 
            {
                empty($params) ? $this->{$filter['action']}() : $this->{$filter['action']}($params);
            }
            elseif ($except && ! in_array($called_action, $filter['except'])) 
            {
                empty($params) ? $this->{$filter['action']}() : $this->{$filter['action']}($params);
            }
            elseif ( ! $only && ! $except) 
            {
                empty($params) ? $this->{$filter['action']}() : $this->{$filter['action']}($params);
            }
            return true;
        }
        else
        {
            log_message('error', "Invalid action {$filter['action']} given to filter system in controller ".get_called_class());
            return false;
        }
    }
    protected function multiple_filter_actions($filter_type) 
    {
        return ! empty($this->{$filter_type}) && array_keys($this->{$filter_type}) === range(0, count($this->{$filter_type}) - 1);
    }

    /*
     *
     * Example callbacks for filters
     * Callbacks can optionally have one parameter consisting of the
     * parameters passed to the called action.
     *
     */
    protected function redirect_if_logged_in()
    {
        
    }
    protected function redirect_if_not_logged_in()
    {
        if(!$this->check_user())
        {
            redirect(base_url());
        }
    }


    /**
     * Language initializer
     */
    public function initialize_lang()
    {
        $ci = &get_instance();

        $available_languages = $ci->config->item('available_languages');
        if (isset($_GET['lang']) && in_array($_GET['lang'], array_keys($available_languages))) {
            $lang = $_GET['lang'];
        } else {
            $lang = $ci->session->userdata('lang');
            if (!$lang) {
                $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            }

        }
        $ci->session->set_userdata(array('lang' => $lang));

        $available_locales = $ci->config->item('available_locales');
        if (in_array($lang, array_keys($available_locales))) {
            setlocale(LC_ALL, $available_locales[$lang]);
        } else {
            setlocale(LC_ALL, $ci->config->item('locale'));
        }

        if (in_array($lang, array_keys($available_languages))) {
            $lang_dir = $available_languages[$lang];
            if ($lang != $ci->config->item('language')) {
                $ci->lang->switch_lang($lang_dir);
            }
        }
    }

    /**
     * check if post is cross-site (like login, register, password retrieval)
     *
     * @return void
     */
    public function check_post()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($this->is_post()) {
            $this->form_validation->set_error_delimiters('', '');
            switch ($this->input->post('form_name')) {
                case 'login':
                    $this->form_validation->set_rules('login_email', lang('app_email'), 'required|valid_email');
                    $this->form_validation->set_rules('login_password', lang('app_password'), 'required');

                    $current_user = false;
                    if ($this->form_validation->run() == false) {
                        return $this->set_data('open_modal', 'login');
                    }
                    
                    $email = $this->input->post('login_email');
                    $password = $this->input->post('login_password');
                    if (!$current_user = $this->get_user($email, $password)) 
                    {
                        return $this->set_data('open_modal', 'login');
                    }

                    if(!$current_user->is_active())
                    {
                        $this->errors[] = 'Seu usuário ainda não foi confirmado. Por favor acesse o link enviado ao seu e-mail para continuar o cadastro.';
                        return;
                    }

                    $this->set_currentuser($current_user); //user ok
                    if (isset($_GET['from']) && ($redirect = $_GET['from'])) {
                        return redirect($redirect);
                    }
                    
                    break;
                case 'register':
                    $this->form_validation->set_rules('register_email', lang('app_email'), 'required|valid_email');
                    $this->form_validation->set_rules('register_password', lang('app_password'), 'required|min_length[5]|max_length[15]');
                    $this->form_validation->set_rules('confirm_password', lang('app_confirm_password'), 'required|matches[register_password]');

                    if ($this->form_validation->run() !== false) {
                        $email = $this->input->post('register_email');
                        $password = $this->input->post('register_password');

                        // check if email already exists
                        $this->load->model('User_model');

                        if ($this->User_model->email_exists($email)) {
                            $this->errors[] = sprintf(lang('app_register_email_exists_error'), $email);
                            $this->set_data('open_modal', 'register');
                        } else {
                            $current_user = $this->register($email, $password);
                            if ($current_user) {
                                $this->load->helper('email');
                                email_user_confirmation($current_user);
                                admin_report("New user: $email", "Check his profil: " . $current_user->get_url());
                                $this->session->set_flashdata('messages', ['Favor verifique seu e-mail para continuar o cadastro']);
                                redirect(site_url('/'));
                            } else {
                                $this->errors[] = sprintf(lang('app_register_error'), $email);
                                $this->set_data('open_modal', 'register');
                            }
                        }
                    } else {
                        $this->set_data('open_modal', 'register');
                    }
                    break;

                case 'password':
                    $this->form_validation->set_rules('password_email', lang('app_email'), 'required|valid_email');

                    if ($this->form_validation->run() !== false) {
                        $email = $this->input->post('password_email');
                        if ($this->retrieve_password($email)) {
                            $this->messages[] = sprintf(lang('app_retrieve_password_success'), $email);
                        } else {
                            $this->errors[] = sprintf(lang('app_retrieve_password_error'), $email);
                        }
                    } else {
                        $this->set_data('open_modal', 'password');
                    }
                    break;

                case 'new_activity':
                    if (!$this->save_activity()) {
                        $this->set_data('open_modal', 'newActivity');
                    }

                    break;

                case 'apply':
                    $this->form_validation->set_rules('comment', lang('app_apply_comment'), 'max_length[1000]');

                    if ($this->form_validation->run() !== false) {
                        $this->apply();
                    } else {
                        $this->set_data('open_modal', 'apply');
                    }
                    break;

            }

        }

    }

    /**
     * Get current user
     */
    public function get_currentuser()
    {
        return $this->get_data('current_user');
    }

    /**
     * Checks if current user is authenticated (has signed in).
     *
     * @param int $type
     * @param boolean $redirect
     * @return boolean
     */
    public function check_user($type = null, $redirect = true)
    {
        $current_user = $this->get_currentuser();
        return $this->validation->check_user($current_user, $type, $redirect);
    }

     /**
     * Get a user by email and password.
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    protected function get_user($email, $password)
    {
        $this->load->model('User_model');
        $user = $this->User_model->get_by_email($email);
        $password = $this->User_model->encrypt_password($password);
        if (!is_null($user) && ($password === $user->password)) {
            return $user;
        }
        return false;
    }

    /**
     * Register and log user in.
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    protected function register($email, $password)
    {
        $this->load->model('User_model');
        $user = new User_model();

        $user->email = $email;
        $user->password = $this->User_model->encrypt_password($password);
        $user->set_confirmation();

        if ($user->insert()) {
            return $user;
        } else {
            return false;
        }
    }

    /**
     * Retrieve user password.
     *
     * @param string $email
     * @return boolean
     */
    protected function retrieve_password($email)
    {
        $this->load->model('User_model');
        if ($user = $this->User_model->get_by_email($email)) {
            $password = $user->reset_password();

            $this->load->helper('email');
            email_user_password($user, $email, $password);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Update or insert an activity.
     *
     * @return boolean
     */
    protected function save_activity()
    {
        $current_user = $this->get_currentuser();
        $activity_id = $this->input->post('id');
        if (!$current_user) {
            $this->errors[] = lang('app_no_current_user_error');
            return false;
        } else {
            $this->form_validation->set_rules('name', lang('app_activity_name'), 'required');

            if ($this->form_validation->run() !== false) {
                $this->load->model('activity_Model');

                $activity = new activity_Model();
                if ($activity_id) {
                    $activity->id = $activity_id;
                }

                $activity->name = $this->input->post('name');
                $activity->owner = $current_user->id;
                if ($description = $this->input->post('description')) {
                    $activity->description = trim($description);
                }

                if ($activity->save()) {

                    $activity_users = $this->input->post('activity_users');
                    $activity_users = ($activity_users) ? explode(',', $activity_users) : array();
                    $activity->set_users($activity_users);

                    return true;
                } else {
                    $this->errors[] = sprintf(lang('app_activity_save_error'), $this->config->item('contact_email'));
                }
            } else {
                return false;
            }
        }

    }

    /**
     * Register current user for activity
     */
    protected function apply()
    {
        $current_user = $this->get_currentuser();
        if (!$current_user) {
            $this->errors[] = lang('app_no_current_user_error');
            return false;
        }
        $activity_id = $this->input->post('id');
        $this->load->model('activity_Model');
        $activity = new Activity_model; //unnecessary
        $activity = $this->activity_Model->get_by_id($activity_id);

        $comment = $this->input->post('comment');
        if (!$comment || empty($comment)) {
            $comment = null;
        }

        if ($activity && $activity->apply($current_user, $comment)) {
            $this->messages[] = lang('app_apply_success');
            $this->load->helper('email');
            email_activity_apply($activity, $current_user, $comment);
            return true;
        } else {
            $this->errors[] = lang('app_apply_error');
            return false;
        }

    }

    /**
     * Set user as current user
     */
    protected function set_currentuser($user)
    {
        if ($user) {
            $this->session->set_userdata('user_id', $user->id);
            $this->set_data('current_user', $user);
        }
    }

    /**
     * Was the request submited via POST method?
     *
     * @return boolean
     */
    public function is_post()
    {
        return 'POST' === $this->input->server('REQUEST_METHOD');
    }

    /**
     * Was the request submited via GET method?
     *
     * @return boolean
     */
    public function is_get()
    {
        return 'GET' === $this->input->server('REQUEST_METHOD');
    }

    /**
     * Gets some data by key from controller.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function get_data($key = null, $default = null)
    {
        $this->_data['errors'] = $this->errors;
        $this->_data['messages'] = $this->messages;
        if (defined('ENVIRONMENT') && in_array(ENVIRONMENT, array('development'))) {
            $this->_data['debug'] = $this->debug;
        }

        if (null === $key) {
            return $this->_data;
        }
        if (!(is_string($key) and isset($this->_data[$key]))) {
            return $default;
        }
        return $this->_data[$key];
    }

    /**
     * Sets a data slot to send to view.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected function set_data($key, $value = null)
    {
        is_string($key) and $this->_data[$key] = $value;
    }


    /**
     * Sets an array of data to send to view.
     *
     * @param array $values
     * @return void
     */
    protected function set_data_array($values)
    {
        foreach ($values as $key => $value) {
            is_string($key) and $this->_data[$key] = $value; 
        }
    }

    /**
     * Outputs an object or array in JSON format with HTTP headers.
     *
     * @param mixed $var
     * @return void
     */
    protected function output_json($var)
    {
        $json = json_encode($var);
        $this->output->set_header('Content-Type: application/json; charset=' . $this->config->item('charset'));
        $this->output->set_header('Content-Length: ' . strlen($json));
        $this->output->set_output($json);
    }

    /**
     * Redirect to referer
     * @param $url fallback redirect
     */
    protected function redirect_referer($url = '/')
    {
        $this->load->library('user_agent');
        redirect(($this->agent->is_referral()) ? $this->agent->referrer() : $url);
    }


    protected function render($view, $data = null)
    {
        $view_data = $this->get_data();
        if(is_array($data))
        {
            $view_data = array_merge($view_data, $data);
        }
        $this->load->view($view, $view_data);
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
