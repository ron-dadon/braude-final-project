<?php

class Main_Controller extends IACS_Controller
{

    public function index()
    {
        if (!$this->is_logged_in())
        {
            //$this->redirect('/login');
        }
        $this->load_view()->render();
    }

    public function error()
    {
        $this->load_view()->render();
    }

    public function login()
    {
        $this->load_view()->render();
    }

    public function logout()
    {
        $this->load_view()->render();
    }

    public function forgot_password()
    {
        $this->load_view()->render();
    }

    public function password_reset()
    {
        $this->load_view()->render();
    }

} 