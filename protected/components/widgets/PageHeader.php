<?php

/**
 * Generates a standardised page header
 *
 * @package EOrganiser_Widget
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 *
 * @property string $title The page title
 * @property string $description The page description (optional)
 * @property array $buttons The primary action buttons for the page
 * @property boolean $useMarkdown Determines if the description should be processed using markdown
 */
class PageHeader extends CWidget
{
    /**
     * The page title
     *
     * @var string
     */
    public $title;

    /**
     * The page description (optional)
     *
     * @var string
     */
    public $description = '';//'Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu ';

    /**
     * The primary action buttons for the page
     * @var array
     */
    public $buttons;

    /**
     * Use the markdown syntax for the description,
     * disabled by default for performance
     *
     * @var boolean
     */
    public $useMarkdown = false;
    public $encode = true;

    private $_buttonClass = 'bootstrap.widgets.BootButton';


    public function run()
    {
        echo '<div class="header">';
        echo '<h1>'.CHtml::encode($this->title).'</h1>';
        if (!empty($this->description)) {
            echo $this->_getDescription();
        }
        echo $this->_getButtons();
        echo '</div>';
    }

    private function _getDescription()
    {
        if ($this->useMarkdown) {
            $p = new CMarkdownParser;
            return $p->transform($this->description);
        } else {
            $d = $this->encode ? CHtml::encode($this->description) : $this->description;
            return '<p>'.str_replace("\n", '</p><p>', $d).'</p>';
        }
    }

    private function _getButtons()
    {
        if (!$this->buttons) {
            return;
        }
        $html = '';
        foreach ($this->buttons as $button) {
            if (isset($button['visible']) && $button['visible'] === false) {
                continue;
            }
            unset($button['visible']);
            $html .= $this->widget($this->_buttonClass, $button, true);
            $html .= ' ';
        }
        return '<div class="actions">'.$html.'</div>';
    }

}