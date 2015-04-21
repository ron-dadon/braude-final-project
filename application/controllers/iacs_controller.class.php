<?php

abstract class IACS_Controller extends Trident_Abstract_Controller
{

    /**
     * Validate a user is logged in.
     *
     * @return bool True if user is logged in, false otherwise.
     */
    protected function is_logged_in()
    {
        return $this->session->get('logged_in') === true;
    }

    /**
     * Validate a logged user is an administrator.
     *
     * @return bool True if user is administrator, false otherwise.
     */
    protected function is_admin()
    {
        return $this->session->get('admin') === true;
    }

    /**
     * Check if a logged user got a specific permission.
     *
     * @param string $permission Permission name.
     *
     * @return bool True if the user got the permission, false otherwise.
     */
    protected function got_permission($permission)
    {
        $permissions = $this->session->get('permissions');
        if ($permissions === null || !is_array($permissions))
        {
            return false;
        }
        if (!array_key_exists($permission, $permissions))
        {
            return false;
        }
        return $permissions[$permission] === true;
    }

    /**
     * Update the logged user information in the database.
     * Re-fetch the user for the database, in case an administrator changed his permissions or
     * removed the user from the database while the user was logged in.
     */
    protected function update_logged_user()
    {
        // TODO: implement update logged user method.
    }

    /**
     * Return the logged in user object.
     *
     * @return User_Entity|null
     */
    protected function get_logged_user()
    {
        $user = $this->session->get('user');
        if ($user === null)
        {
            return null;
        }
        $user = unserialize($user);
        return $user;
    }

    public function set_alert($type, $title, $message)
    {
        switch ($type)
        {
            case 'success':
                $icon = 'fa fa-fw fa-check-circle';
                break;
            case 'danger':
                $icon = 'fa fa-fw fa-times-circle';
                break;
            case 'warning':
                $icon = 'fa fa-fw fa-exclamation-circle';
                break;
            case 'info':
                $icon = 'fa fa-fw fa-info-circle';
                break;
            default:
                $icon = 'fa fa-fw fa-circle';
        }
        $alert = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon
        ];
        $this->session->set('alert', $alert);
    }

    /**
     * Load view instance.
     * If $view is not specified, loads the view according to the calling callable (controller_function_view).
     * Automatically add important data to the view data.
     *
     * @param array $view_data View data array.
     * @param null  $view      View name.
     *
     * @return Trident_Abstract_View View instance.
     */
    protected function load_view($view_data = [], $view = null)
    {
        if (is_null($view))
        {
            $view = debug_backtrace()[1]['function'];
            $view = str_replace('_controller', '', strtolower(get_class($this))) . '_' . $view . '_view';
        }
        $view_data['user'] = $this->get_logged_user();
        $view_data['alert'] = $this->session->pull('alert');
        $view_data['controller'] = str_replace('_controller', '', strtolower(get_class($this)));
        return parent::load_view($view_data, $view);
    }

}