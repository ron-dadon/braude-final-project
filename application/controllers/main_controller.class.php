<?php


class Main_Controller extends IACS_Controller
{

    public function index()
    {
        $this->only_logged_in();
        $view_data['current-menu'] = 'home';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function search()
    {
        $this->only_logged_in();
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
        if ($this->is_logged_in())
        {
            $this->redirect('/');
        }
        $view_data = [];
        if ($this->request->type === 'POST')
        {
            $this->load_database();
            /** @var Users_Model $users */
            $users = $this->load_model('users');
            $email = $this->request->post->get('user_email', true);
            $password = $this->request->post->get('user_password', true);
            if ($email !== null && $password !== null)
            {
                /** @var User_Entity $user */
                $user = $users->get_user_by_login_information($email, $password);
                if ($user === null)
                {
                    $view_data['login-wrong'] = true;
                    $view_data['last-user-email'] = $email;
                    $view_data['last-user-password'] = $password;
                }
                else
                {
                    $this->session->set('user-logged', true);
                    $this->session->set('user-name', $user->name);
                    $this->session->set('user-admin', $user->admin);
                    $this->redirect('/');
                }
            }
            else
            {
                $view_data['login-wrong'] = true;
                $view_data['last-user-email'] = $email;
                $view_data['last-user-password'] = $password;
            }
        }
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