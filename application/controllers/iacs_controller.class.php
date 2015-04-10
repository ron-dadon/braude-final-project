<?php


abstract class IACS_Controller extends Trident_Abstract_Controller
{
    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->load_database();
        if ($this->is_logged_in())
        {
            if (($user = $this->session->get('user-entity')) !== null)
            {
                /** @var User_Entity $user */
                $user = unserialize($user);
                /** @var Users_Model $users */
                $users = $this->load_model('users');
                $user = $users->get_user_by_id($user->id);
                if ($user === null)
                {
                    $this->redirect('/error');
                }
                $user->last_activity = date('Y-m-d H:i:s');
                $user->last_ip = $this->request->from_ip;
                $user->last_browser = $this->request->browser . ' ' . $this->request->browser_version;
                $user->last_platform = $this->request->platform;
                if (!$users->update_user($user))
                {
                    $this->session->destroy();
                    $this->redirect('/error');
                }
                $this->session->set('user-entity', serialize($user));
                $this->session->set('user-name', $user->name);
                $this->session->set('user-admin', $user->admin ? true : false);
            }
            else
            {
                $this->session->destroy();
                $this->redirect('/login');
            }
        }
    }


    protected function get_connected_user_name()
    {
        return $this->session->get('user-name');
    }

    protected function only_logged_in()
    {
        if (!$this->is_logged_in())
        {
            $this->redirect('/login');
        }
    }

    protected function only_admin()
    {
        if (!$this->is_admin())
        {
            $this->redirect('/');
        }
    }

    public function is_logged_in()
    {
        return $this->session->get('user-logged') === true;
    }

    public function is_admin()
    {
        return $this->session->get('user-admin') === true;
    }

    protected function load_view($view_data = [], $view = null)
    {
        if (is_null($view))
        {
            $view = debug_backtrace()[1]['function'];
            $view = str_replace('_controller', '', strtolower(get_class($this))) . '_' . $view . '_view';
        }
        $view_data['is_admin'] = $this->is_admin();
        return parent::load_view($view_data, $view);
    }
}