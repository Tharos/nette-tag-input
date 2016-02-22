<?php

namespace Achse\TagInput\Tests;

require_once __DIR__ . '/bootstrap.php';

use Achse\TagInput\DataSourceDescriptor;
use Achse\TagInput\TagInput;
use Nette\Forms\Form;
use Tester\Assert;
use Tester\TestCase;



/**
 * @testCase
 */
class TagInputTest extends TestCase
{

	public function testJsonEncode()
	{
		$form = new Form();

		$descriptor = new DataSourceDescriptor('https://lister.red-dwarf.jup');
		$descriptor->setLabelPropertyName('label2');
		$descriptor->setValuePropertyName('value2');

		$form['tagInput'] = $tagInput = new TagInput($descriptor, 'Sent to');

		$expected = '<input type="text" name="tagInput" id="frm-tagInput" data-tagInput=\''
			. '{"url":"https://lister.red-dwarf.jup","valuePropertyName":"value2","labelPropertyName":"label2"}'
			. '\'>';

		Assert::equal($expected, (string) $tagInput->getControl());
	}

}



(new TagInputTest())->run();





