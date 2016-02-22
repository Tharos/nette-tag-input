![](https://travis-ci.org/Achse/nette-tag-input.svg?branch=master)
![](https://scrutinizer-ci.com/g/Achse/nette-tag-input/badges/quality-score.png?b=master)
![](https://scrutinizer-ci.com/g/Achse/nette-tag-input/badges/coverage.png?b=master)

This is Nette adaptation for: https://github.com/bootstrap-tagsinput/bootstrap-tagsinput

![](https://raw.githubusercontent.com/Achse/nette-tag-input/master/examples/example.png)

# Installation

## Composer:
> **Disclaimer:** One day I maybe add package to https://packagist.org. 

```
"require": {
    "achse/nette-tag-input": "@dev"
},
"repositories": [
    { "type": "git", "url": "https://github.com/Achse/nette-tag-input.git" }
]
```

And: `composer update achse/nette-tag-input`

## Javascript Dependencies
```
npm install jquery
npm install bootstrap3
npm install bootstrap-tagsinput
npm install typeahead.js
```

If you are using webloader:
```
webloader:
	css:
		default:
				- %wwwDir%/../node_modules/bootstrap3/dist/css/bootstrap.min.css
				- %wwwDir%/../node_modules/bootstrap3/dist/css/bootstrap-theme.min.css
				- %wwwDir%/../node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput-typeahead.css
				- %wwwDir%/../node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css

	js:
		default:
			files:
				- %wwwDir%/../node_modules/jquery/dist/jquery.js
				- %wwwDir%/../node_modules/bootstrap3/dist/js/bootstrap.min.js
				- %wwwDir%/../node_modules/typeahead.js/dist/typeahead.bundle.js
				- %wwwDir%/../node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.js
				- %wwwDir%/../vendor/achse/nette-tag-input/assets/tagInput.js
````

## Nette Form
You just add this code to your `BaseForm` or trait or whattever adds `addXyzInput` to your forms:

```php
/**
	 * @param string $name
	 * @param string $label
	 * @param DataSourceDescriptor $dataSourceDescriptor
	 * @return TagInput
	 */
	public function addTagInput($name, $label, DataSourceDescriptor $dataSourceDescriptor)
	{
		$input = new TagInput($dataSourceDescriptor, $label);

		return $this[$name] = $input;
	}
```

And usage:
```php
$form = new BaseForm();

$form->addTagInput(
	'to',
	'Send to',
	new DataSourceDescriptor($this->linkGenerator->link('SomeModule:SomePresenter:users'))
);
```

On that URL given by last argument should be something in format like this:
```php
public function renderUsers()
{
	$array = [
		(object) [
			DataSourceDescriptor::DEFAULT_VALUE_PROPERTY => 1,
			DataSourceDescriptor::DEFAULT_LABEL_PROPERTY => 'František Dobrota',
		],
		(object) [
			DataSourceDescriptor::DEFAULT_VALUE_PROPERTY => 2,
			DataSourceDescriptor::DEFAULT_LABEL_PROPERTY => 'Boris Yeltsin',
		],
	];
	
	$this->sendResponse(new JsonResponse($array));
}
```
