<?php


/**
 * Description of FormActionBar
 *
 * @package PACKAGE_NAME
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 */
class FormActionBar extends CWidget
{
    private $_cancelButton = array(
        'label' => 'Cancel',
        'url' => '#',
        'icon' => 'remove'
    );
    private $_submitButton = array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'icon' => 'ok white',
    );

    public $template = '{submit} {cancel}';
    public $buttons = array();

    private $_model;
    public $cancelUrl;
    public $newLabel = 'Save';
    public $editLabel = 'Save';
    public $label = 'Save';

    public function getModel()
    {
        return $this->_model;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }


    public function run()
    {
        echo '<div class="form-actions">';
        echo $this->_generateButtons();
        echo '</div>';
    }

    private function _generateButtons()
    {
        return preg_replace_callback('/\{(\w+)\}/', array($this, '_generateButton'), $this->template);
    }

    private function _generateButton($match)
    {
        $buttonId = $match[1];
        $config = $this->_buttonConfig($buttonId);
        if (!isset($config['visible']) || $config['visible'] === true) {
            unset($config['visible']);
            return $this->widget('bootstrap.widgets.BootButton', $config, true);
        }
        return '';
    }

    private function _buttonConfig($name)
    {
        $config = array();
        switch($name) {
            case 'submit':
                $config = isset($this->buttons[$name]) ? array_merge($this->_submitButton, $this->buttons[$name]) : $this->_submitButton;
                $config['label'] = $this->_submitLabel();
                break;
            case 'cancel':
                $config = isset($this->buttons[$name]) ? array_merge($this->_cancelButton, $this->buttons[$name]) : $this->_cancelButton;
                $config['visible'] = is_array($this->cancelUrl);
                $config['url'] = $this->cancelUrl;
                break;
            default:
                if (isset($this->buttons[$name])) {
                    $config = $this->buttons[$name];
                } else {
                    $config = array('visible' => false);
                }
        }
        return $config;
    }

    private function _submitLabel()
    {
        $label = $this->label;
        if ($this->_model && isset($this->model->isNewRecord)) {
            $label = $this->model->isNewRecord ? $this->newLabel : $this->editLabel;
        }
        return $label;
    }

}