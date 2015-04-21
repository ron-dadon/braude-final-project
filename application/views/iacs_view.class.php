<?php
/**
 * Created by PhpStorm.
 * User: רון
 * Date: 20/04/2015
 * Time: 15:44
 */

abstract class IACS_View extends Trident_Abstract_View
{

    /**
     * Logged user.
     *
     * @var User_Entity
     */
    protected $user;

    function __construct($configuration, $data)
    {
        parent::__construct($configuration, $data);
        $this->user = $this->get('user');
    }

    protected function alert()
    {
        if (($alert = $this->get('alert')) === null)
        {
            return;
        }
        $type = $alert['type'];
        $title = $alert['title'];
        $message = $alert['message'];
        $icon = $alert['icon'];
        echo "<div class=\"alert alert-$type\"><h3 class=\"no-margins\"><i class=\"$icon\"></i> $title</h3><p>$message</p></div>" . PHP_EOL;
    }

    /**
     * @param array $fields
     */
    protected function create_form_fields($fields)
    {
        if (!is_array($fields))
        {
            return;
        }
        foreach ($fields as $name => $field)
        {
            $field_id = str_replace('_', '-', $name);
            $field_type = isset($field['type']) ? $field['type'] : 'text';
            $field_validators = isset($field['validators']) ? implode(' ', $field['validators']) : '';
            $field_place_holder = isset($field['holder']) ? 'placeholder="' . $field['holder'] . '"' : '';
            $field_help = isset($field['help']) ? $field['help'] : '';
            $field_label = isset($field['label']) ? $field['label'] : $name;
            echo '<div class="form-group">' . PHP_EOL;
            echo "\t<label for=\"$field_id\">$field_label</label>" . PHP_EOL;
            echo "<input class=\"form-control\" type=\"$field_type\" id=\"$field_id\" name=\"$name\" $field_validators $field_place_holder>" . PHP_EOL;
            echo "<div class=\"help-block with-errors\">$field_help</div>" . PHP_EOL . "</div>" . PHP_EOL;
        }
    }
}