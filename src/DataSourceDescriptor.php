<?php

namespace Achse\TagInput;

use JsonSerializable;
use Nette\Object;



class DataSourceDescriptor extends Object implements JsonSerializable
{

	const DEFAULT_LABEL_PROPERTY = 'label';
	const DEFAULT_VALUE_PROPERTY = 'value';

	/**
	 * @var
	 */
	private $url;

	/**
	 * @var string
	 */
	private $valuePropertyName = self::DEFAULT_VALUE_PROPERTY;

	/**
	 * @var string
	 */
	private $labelPropertyName = self::DEFAULT_LABEL_PROPERTY;

	/**
	 * @var int|NULL
	 */
	private $maxTags = NULL;



	/**
	 * @param string $url
	 */
	public function __construct($url)
	{
		$this->url = $url;
	}



	/**
	 * @inheritdoc
	 */
	public function jsonSerialize()
	{
		return (object) [
			'url' => $this->url,
			'valuePropertyName' => $this->valuePropertyName,
			'labelPropertyName' => $this->labelPropertyName,
			'maxTags' => $this->maxTags,
		];
	}



	/**
	 * @param string $labelPropertyName
	 */
	public function setLabelPropertyName($labelPropertyName)
	{
		$this->labelPropertyName = $labelPropertyName;
	}



	/**
	 * @param string $valuePropertyName
	 */
	public function setValuePropertyName($valuePropertyName)
	{
		$this->valuePropertyName = $valuePropertyName;
	}



	/**
	 * @param int|NULL $maxTags
	 */
	public function setMaxTags($maxTags)
	{
		$this->maxTags = $maxTags;
	}

}
