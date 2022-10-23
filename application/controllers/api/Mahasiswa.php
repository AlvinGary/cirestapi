<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get()
    {
        $data = $this->model->getMahasiswa();
        // $data2 = $this->model->getMahasiswa();
        // var_dump(json_encode($data));
        $this->set_response([
            'status' => TRUE,
            'code' => 200,
            'message' => 'Success',
            'data' => $data,
            // 'datakhusus' => $data2,
        ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post()
    {
        $to_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('admin@alvin01.com', 'Admin alvin01.com');
        $this->email->to($to_email);
        $this->email->subject('Important Message');
        $this->email->message("
        <body style='outline-style: solid; outline-color: #0084FF; border-radius:10px; margin:20px;'>
            <center>
                <h1 style='color: #1B58FF; font-weight: bold;'>WELCOME TO alvin01 SERVER</h1>
                <img src='https://img.freepik.com/free-vector/welcome-word-flat-cartoon-people-characters_81522-4207.jpg?w=2000' height='300px'>
                <p style='font-size: 16px; font-weight: bold;'>We happy that you have choose to join us!</p>
                <p style='font-size: 16px; font-weight: bold;'>Please explore and enjoy our website service.<p>
                <p style='font-size: 14px;'><a href='https://alvin01.com/cirestapi'>Verify</a> your account if you already registered to our service.</p>
            </center>
        </body>
        ");

        if ($this->email->send()) {
            $this->set_response([
                'status' => TRUE,
                'code' => 200,
                'message' => 'Success to send email notification to Your account!, please check your email inbox'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'code' => 404,
                'message' => 'Failed to send email notification!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
