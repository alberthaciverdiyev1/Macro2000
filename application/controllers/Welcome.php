<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('partials/header');
		$this->load->view('auth');
		$this->load->view('partials/footer');

	}
	public function login()
    {
        $params = [
            "username" => $this->input->get('username'),
            "password" => $this->input->get('password'),
        ];

        $this->load->model('User_model'); 
        $user = $this->User_model->check_user($params['username'], $params['password']);

        if ($user) {
            $this->load->library('session');
            $session_data = [
                'user_id'   => $user->id,
                'username'  => $user->username,
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);
            
            $response = [
                "status" => true,
                "message" => "Login successful",
                "user" => $user
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Invalid username or password"
            ];
        }

        echo json_encode($response);
    }

    public function register()
    {
        $params = [
            "username" => $this->input->get('username'),
            "password" => password_hash($this->input->get('password'), PASSWORD_DEFAULT), 
        ];

        $this->load->model('User_model'); 
        $insert_id = $this->User_model->register_user($params);

        if ($insert_id) {
            $response = [
                "status" => true,
                "message" => "Registration successful",
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Registration failed. Username might already exist."
            ];
        }

        echo json_encode($response);
    }
}
