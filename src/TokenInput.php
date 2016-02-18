<?php

namespace Achse\TokenInput;

use Nette\Forms\Controls\BaseControl;
use Nette\InvalidArgumentException;
use Nette\Latte\Engine;
use Nette\Templating\FileTemplate;
use Nette\Utils\ArrayHash;
use Nette\Utils\Html;
use Nette\Utils\Json;



class TokenInput extends BaseControl
{

	const DEFAULT_TOKEN_DELIMITER = ',';

	protected $defaultValue;

	/**
	 * @var string
	 */
	protected $link;

	/**
	 * @var ArrayHash
	 */
	protected $settings;

	/**
	 * @var mixed internal representation
	 */
	protected $value;

	/**
	 * @var string value entered by user (unfiltered)
	 */
	protected $rawValue;

	/**
	 * @var string class name
	 */
	private $className = 'tokenInput';

	const TEMPLATE_FILE = 'template.latte';



	/**
	 * @param string|NULL $label
	 */
	public function __construct($label = NULL)
	{
		parent::__construct($label);

		$this->control->type = 'text';

		$this->settings = new ArrayHash();
		$this->settings->theme = 'facebook';
		$this->settings->hintText = 'Začněte psát název..';
		$this->settings->preventDuplicates = TRUE;
	}



	/**
	 * @return string
	 */
	public function getClassName()
	{
		return $this->className;
	}



	/**
	 * @param string $className
	 * @return static
	 */
	public function setClassName($className)
	{
		$this->className = $className;

		return $this;
	}



	/**
	 * @return Html
	 */
	public function getControl()
	{
		$container = Html::el('div');
		/** @var $control Html */
		$control = parent::getControl();
		$control->addClass($this->className);

		if ($this->value) {
			$control->value = $this->value;
		}

		$template = $this->getTemplate();
		$script = Html::el();
		$script->setHtml((string) $template);

		$container->add($control);
		$container->add($script);

		return $container;
	}



	/**
	 * @return FileTemplate
	 */
	protected function getTemplate()
	{
		$template = new FileTemplate(__DIR__ . '/template.latte');
		$template->registerHelperLoader('Nette\Templating\Helpers::loader');
		$template->registerFilter(new Engine());

		$template->htmlId = $this->getHtmlId();
		$template->link = $this->link;
		$template->settings = Json::encode($this->settings);

		return $template;
	}



	/**
	 * @return string
	 */
	public function getRawValue()
	{
		return $this->rawValue;
	}



	/**
	 * @param string $name
	 * @param string $value
	 */
	protected function setProperty($name, $value)
	{
		$this->settings->$name = $value;
	}



	/**
	 * @param string $delimiter
	 * @return static
	 */
	public function setTokenDelimiter($delimiter)
	{
		if ($delimiter === self::DEFAULT_TOKEN_DELIMITER) {
			return $this;
		}
		$this->setProperty('tokenLimit', $delimiter);

		return $this;
	}



	/**
	 * @return string
	 */
	public function getTokenDelimiter()
	{
		if (isset($this->settings->delimiter)) {
			return $this->settings->delimiter;
		} else {
			return self::DEFAULT_TOKEN_DELIMITER;
		}
	}



	/**
	 * @param int $num
	 * @return static
	 */
	public function setLimit($num)
	{
		if (!is_int($num) || $num < 1) {
			throw new InvalidArgumentException('Argument must be integer bigger than 0.');
		}
		$this->setProperty('tokenLimit', $num);

		return $this;
	}



	/**
	 * @param string $text
	 * @return static
	 */
	public function setTheme($text)
	{
		$this->setProperty('theme', $text);

		return $this;
	}



	/**
	 * @param string $val
	 * @return static
	 */
	public function setPreventDuplicates($val)
	{
		$this->setProperty('preventDuplicates', $val);

		return $this;
	}



	/**
	 * @param string $val
	 * @return static
	 */
	public function setOnAdd($val)
	{
		$this->setProperty('onAdd', $val);

		return $this;
	}



	/**
	 * @param string $text
	 * @return static
	 */
	public function setHintText($text)
	{
		$this->setProperty('hintText', $text);

		return $this;
	}



	/**
	 * @param array $prePopulated
	 * @return static
	 */
	public function setPrePopulated(array $prePopulated)
	{
		$this->setProperty('prePopulate', $prePopulated);

		return $this;
	}



	/**
	 * @param string $id
	 * @param string $name
	 * @return static
	 */
	public function addPrePopulated($id, $name)
	{
		if ($name == '') {
			return $this;
		}

		if (isset($this->settings->prePopulate)) {
			$this->settings->prePopulate[] = ['id' => $id, 'name' => $name];
		} else {
			$this->settings->prePopulate = [['id' => $id, 'name' => $name]];
		}

		return $this;
	}



	/**
	 * @param string $link
	 * @return static
	 */
	public function setLink($link)
	{
		$this->link = $link;

		return $this;
	}



	/**
	 * @return string
	 */
	public function getLink()
	{
		return $this->link;
	}



	/**
	 * @return array
	 */
	public function getValue()
	{
		$value = parent::getValue();

		return $value == '' ? $this->defaultValue : explode($this->getTokenDelimiter(), $value);
	}



	public function isFilled()
	{
		return count($this->getValue()) != 0;
	}



	/**
	 * @param mixed $value
	 * @return static
	 */
	public function setDefaultValue($value)
	{
		$this->defaultValue = $value;

		return $this;
	}

}
