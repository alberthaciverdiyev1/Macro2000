<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    private function checkAccess($role = null) {
		$this->load->library('session');
        return ($this->session->userdata('is_logged') && $this->session->userdata('role') == $role) ? true : false;
    }
	public function index()
	{
        $this->load->library('session');
        $this->session->userdata('is_logged') ? ( $this->session->userdata('role') === "admin" ? redirect('task-list'):redirect('customer-request')):"";
		$this->load->view('partials/header');
		$this->load->view('auth');
		$this->load->view('partials/footer');

	}
	public function login()
    {
		$this->load->library('session');
        $this->session->userdata('is_logged') ? ( $this->session->userdata('role') === "admin" ? redirect('task-list') : redirect('customer-request')) : "";
        $params = [
            "username" => $this->input->post('username'),
            "password" => $this->input->post('password'),
        ];

        $this->load->model('User_model'); 
        $user = $this->User_model->check_user($params['username'], $params['password']);
        if ($user) {
            $this->load->library('session');
            $session_data = [
                'user_id'   => $user->id,
                'username'  => $user->username,
                'role'  	=> $user->role,
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
            "username" => $this->input->post('username'),
            "password" => $this->input->post('password'), 
            // "password" => password_hash($this->input->post('password'), PASSWORD_DEFAULT), 
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

	public function taskList(){
        // if(self::checkAccess("admin")){
        $params = [
            "only_requests"=> $this->input->get("only_requests"),
        ];
            $this->load->model('Task_model'); 
            $data = $this->Task_model->getList( $params);
            echo json_encode($data);
        // }

	}
	public function taskListView(){
        // if(self::checkAccess("admin")){

		$this->load->view('partials/header');
		$this->load->view('task_list');
		$this->load->view('partials/footer');
	// }
}
	public function customerRequest(){
		$this->load->view('partials/header');
		$this->load->view('customer_request');
		$this->load->view('partials/footer');
	}
	public function addCustomerRequest() {
		$this->load->library('session');
		$params = [
            "customer_name" => $this->input->post('customer_name'),
			"from_user_id" =>  $this->session->userdata('user_id'),
			"status" =>  0
        ];

        $this->load->model('Task_model'); 
        $response = $this->Task_model->add($params);

        echo json_encode($response);
	}

    public function deleteRequest() {
        $this->load->model('Task_model'); 
        $response = $this->Task_model->add($this->input->post('id'));

        echo json_encode($response);
	}

    public function addNewCustomer() {
        $this->load->model('Task_model'); 
        $response = $this->Task_model->updateAndAddCustomer(['id' => $this->input->post('id')]);
    }
    public function CustomerRequestListView() {
        $this->load->view('partials/header');
		$this->load->view('request_list');
		$this->load->view('partials/footer');
    }
}
