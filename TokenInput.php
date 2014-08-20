<?php

namespace Achse\Controls;

use Nette\ArrayHash;
use Nette\Forms\Controls\BaseControl;
use Nette\InvalidArgumentException;
use Nette\Latte\Engine;
use Nette\Templating\FileTemplate;
use Nette\Utils\Html;
use Nette\Utils\Json;
use Nette\Utils\Validators;

class TokenInput extends BaseControl {


    protected $defaultValue;

    /** @var  String */
    protected $link;

    /** @var  ArrayHash */
    protected $settings;

    /** @var internal representation */
    protected $value;

    /** @var string value entered by user (unfiltered) */
    protected $rawValue;

    /** @var string class name */
    private $className = 'tokenInput';

    const TEMPLATE_FILE = "template.latte";

    public function __construct($label = NULL) {
        parent::__construct($label);
        $this->control->type = 'text';


        $this->settings = new ArrayHash();
        $this->settings->theme = "facebook";
        $this->settings->hintText = "Začněte psát název..";
        $this->settings->preventDuplicates = true;
    }


    public function getClassName() {
        return $this->className;
    }

    public function setClassName($className) {
        $this->className = $className;
        return $this;
    }

    /**
     * @return Html
     */
    public function getControl() {
        $container = Html::el('div');
        /** @var $control Html */
        $control = parent::getControl();
        $control->addClass($this->className);


        if ($this->value) {
            $control->value = $this->value;
        }

        $template = $this->getTemplate();
        $script = Html::el();
        $script->setHtml((string)$template);

        $container->add($control);
        $container->add($script);

        return $container;
    }


    protected function getTemplate() {
        $template = new FileTemplate(__DIR__ . '/template.latte');
        $template->registerHelperLoader('Nette\Templating\Helpers::loader');
        $template->registerFilter(new Engine);

        $template->htmlId = $this->getHtmlId();
        $template->link = $this->link;
        $template->settings = Json::encode($this->settings);
        $template->settings2 = $this->settings;

        return $template;
    }

    /**
     * @return   string
     */
    public function getRawValue() {
        return $this->rawValue;
    }

    protected function setProperty($name, $value) {
        $this->settings->$name = $value;
    }

    public function setTokenDelimiter($delimiter) {
        if ($delimiter == ",") {
            return $this;
        }
        $this->setProperty('tokenLimit', $delimiter);
        return $this;
    }

    public function getTokenDelimiter() {
        if (isset($this->settings->delimiter)) {
            return $this->settings->delimiter;
        } else {
            return ",";
        }
    }

    public function setLimit($num) {
        if (!is_int($num) || $num < 1) {
            throw new InvalidArgumentException("Argument must be integer bigger than 0.");
        }
        $this->setProperty('tokenLimit', $num);
        return $this;
    }

    public function setTheme($text) {
        $this->setProperty('theme', $text);
        return $this;
    }

    public function setPreventDuplicates($val) {
        $this->setProperty('preventDuplicates', $val);
        return $this;
    }

    public function setOnAdd($val) {
        $this->setProperty('onAdd', $val);
        return $this;
    }

    public function setHintText($text) {
        $this->setProperty('hintText', $text);
        return $this;
    }

    public function setPrePopulated(array $prePopulated) {
        $this->setProperty('prePopulate', $prePopulated);
        return $this;
    }

    public function addPrePopulated($id, $name) {
        if ($name == "") {
            return $this;
        }

        if (isset($this->settings->prePopulate)) {
            $this->settings->prePopulate[] = array('id' => $id, 'name' => $name);
        } else {
            $this->settings->prePopulate = array(array('id' => $id, 'name' => $name));
        }
        return $this;
    }

    /**
     * @param String $link
     * @return $this
     */
    public function setLink($link) {
        $this->link = $link;
        return $this;
    }

    /**
     * @return String
     */
    public function getLink() {
        return $this->link;
    }

    public function getValue() {
        $value = parent::getValue();
        return $value == "" ? $this->defaultValue : explode($this->getTokenDelimiter(), $value);
    }

    public function isFilled() {
        return count($this->getValue()) != 0;
    }

    /**
     * Ignored, use setPrePopulated or addPrePopulated instead
     * @param $value
     * @return $this|BaseControl
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setDefaultValue($value) {
        $this->defaultValue = $value;
        return $this;
    }

    public static function validateemail(TokenInput $control) {
        $arr =  ($control->getValue());
        foreach ($arr as $value) {
            if (!Validators::isEmail($value)) {
                return false;
            }
        }
        return true;
    }

}