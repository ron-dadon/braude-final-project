<?php


class Main_Controller extends IACS_Controller
{

    public function index()
    {
        $this->only_connected();
        $view_data['current-menu'] = 'home';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function search()
    {
        $this->only_connected();
        if ($this->request->type === 'POST')
        {
            $view_data['search-term'] = $this->request->post->get('global_search');
        }
        $view_data['current-menu'] = 'home';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function login()
    {
        if ($this->request->type === 'POST')
        {
            $this->session->set('login-wrong', true);
            $this->redirect('/login');
        }
        $view_data['login-wrong'] = $this->session->pull('login-wrong');
        $this->load_view($view_data)->render();
    }

    public function logout()
    {
        $this->session->destroy();
        $this->redirect('/login');
    }

    public function error()
    {
        $this->load_view()->render();
    }
} 