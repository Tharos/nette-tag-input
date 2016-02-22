<?php

namespace Achse\TagInput\Tests;

require_once __DIR__ . '/bootstrap.php';

use Achse\TagInput\DataSourceDescriptor;
use Nette\Utils\Json;
use Tester\Assert;
use Tester\TestCase;



/**
 * @testCase
 */
class DataSourceDescriptorTest extends TestCase
{

	public function testJsonEncode()
	{
		$descriptor = new DataSourceDescriptor('https://lister.red-dwarf.jup');
		$descriptor->setLabelPropertyName('label2');
		$descriptor->setValuePropertyName('value2');

		Assert::equal(
			'{"url":"https://lister.red-dwarf.jup","valuePropertyName":"value2","labelPropertyName":"label2"}',
			Json::encode($descriptor)
		);
	}

}



(new DataSourceDescriptorTest())->run();





