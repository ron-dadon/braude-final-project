<?php

class Users_Controller extends IACS_Controller
{

    public function index()
    {
        /** @var Users_Model $model */
        $model = $this->load_model('users');
        $users = $model->get_all();
        $view_data['users'] = $users;
        $this->load_view($view_data)->render();
    }

    public function add()
    {

    }

    public function show($id)
    {
        /** @var Users_Model $model */
        $model = $this->load_model('users');
        $user = $model->get_by_id($id);
        if ($user === null)
        {
            $this->set_alert('danger', 'Cant restore user information', 'Cant restore information for user with an id of $id. User does not exists.');
            $this->redirect('/administration/users');
        }
        $view_data['user'] = $user;
        $this->load_view($view_data)->render();
    }

    public function edit($id)
    {
        /** @var Users_Model $model */
        $model = $this->load_model('users');
        $user = $model->get_by_id($id);
        if ($user === null)
        {
            $this->set_alert('danger', 'Cant restore user information', 'Cant restore information for user with an id of $id. User does not exists.');
            $this->redirect('/administration/users');
        }
        $view_data['user'] = $user;
        $this->load_view($view_data)->render();
    }

    public function delete($id)
    {

    }

}