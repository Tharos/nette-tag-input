<?php

namespace Achse\TokenInput;

use Nette\Forms\Controls\TextInput;
use Nette\Utils\Json;



class TokenInput extends TextInput
{

	/**
	 * @var DataSourceDescriptor
	 */
	private $dataSourceDescriptor;



	/**
	 * @inheritdoc
	 */
	public function __construct(DataSourceDescriptor $dataSourceDescriptor, $label = NULL, $maxLength = NULL)
	{
		parent::__construct($label, $maxLength);

		$this->dataSourceDescriptor = $dataSourceDescriptor;
	}



	/**
	 * @inheritdoc
	 */
	public function getControl()
	{
		$input = parent::getControl();
		$input->addAttributes(['data-tokenInput' => Json::encode($this->dataSourceDescriptor)]);

		return $input;
	}

}
