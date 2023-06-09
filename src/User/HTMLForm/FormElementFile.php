<?php

namespace Alfs18\User\HTMLForm;
// namespace Anax\HTMLForm;

use Anax\HTMLForm\FormElementInput;

/**
 * Form element
 */
class FormElementFile extends FormElementInput
{
    /**
     * Constructor
     *
     * @param string $name       of the element.
     * @param array  $attributes to set to the element. Default is an empty
     *                           array.
     */
    public function __construct($name, $attributes = [])
    {
        parent::__construct($name, $attributes);
        $this['type'] = 'file';
        $this->UseNameAsDefaultLabel();
    }
}
