<?php

class Main_Controller extends IACS_Controller
{

    public function index()
    {
        $this->load_view()->render();
    }

    public function error()
    {
        $this->load_view()->render();
    }

    public function login()
    {
        if ($this->request->is_post())
        {
            $this->set_alert('success', 'התחברת בהצלחה!', 'כל הכבוד!');
        }
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