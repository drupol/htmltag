[![Latest Stable Version](https://poser.pugx.org/drupol/htmltag/v/stable)](https://packagist.org/packages/drupol/htmltag)
 [![Total Downloads](https://poser.pugx.org/drupol/htmltag/downloads)](https://packagist.org/packages/drupol/htmltag)
 [![Build Status](https://travis-ci.org/drupol/htmltag.svg?branch=master)](https://travis-ci.org/drupol/htmltag)
 [![Build status](https://ci.appveyor.com/api/projects/status/bfo6bgublcdwxl0r/branch/master?svg=true)](https://ci.appveyor.com/project/drupol/htmltag/branch/master)
 [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/drupol/htmltag/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drupol/htmltag/?branch=master)
 [![Code Coverage](https://scrutinizer-ci.com/g/drupol/htmltag/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/drupol/htmltag/?branch=master)
 [![Codacy Badge](https://api.codacy.com/project/badge/Grade/123c1ea942b14393b04d87864f165a53)](https://www.codacy.com/app/drupol/htmltag)
 [![Mutation testing badge](https://badge.stryker-mutator.io/github.com/drupol/htmltag/master)](https://stryker-mutator.github.io)
 [![License](https://poser.pugx.org/drupol/htmltag/license)](https://packagist.org/packages/drupol/htmltag)

# HTMLTag

## Description

This is a PHP library that handles the generation of HTML tags, their attributes and content.

The focus is on security, speed and usability.

## Requirements

* PHP 5.6 for regular usage.
* PHP 7 for development and running tests.

## Installation

```composer require drupol/htmltag --dev```

## Usage

```php
// Meta object.
$meta = \drupol\htmltag\HtmlTag::tag('meta', ['name' => 'author']);
$meta->attr('content', 'pol dellaiera');

// Title object.
$title = \drupol\htmltag\HtmlTag::tag('h1', ['class' => 'title'], 'Welcome to HTMLTag');

// Paragraph object.
$paragraph = \drupol\htmltag\HtmlTag::tag('p', ['class' => 'section']);
$paragraph->attr('class')->append('paragraph');
$paragraph->content('This library helps you create HTML.');

// Simple footer
$footer = \drupol\htmltag\HtmlTag::tag('footer', [], 'Thanks for using it!');

// Body tag.
// Add content that can be transformed into strings.
$body = \drupol\htmltag\HtmlTag::tag('body', [], [$title, $paragraph, $footer]);

// Fix something that was already added.
$paragraph->attr('class')->remove('section')->replace('paragraph', 'description');

// Alter the values of a specific attributes.
$meta->attr('content')->alter(
    function ($values) {
        return array_map('strtoupper', $values);
    }
);

echo $meta . $body;
```

Will print:

```html
<meta content="POL DELLAIERA" name="author"/>
<body>
  <h1 class="title">Welcome to HTMLTag</h1>
  <p class="description">This library helps you create HTML.</p>
  <footer>Thanks for using it!</footer>
</body>
```

# HTML Builder

The library comes with an HTML Builder class that allows you to quickly create HTML content.

```php
$builder = new HtmlBuilder();
$html = $builder
    ->c(' Comment 1 ') // Add a comment
    ->p(['class' => ['paragraph']], 'some content')
    ->div(['class' => 'container'], 'this is a simple div')
    ->_() // End tag <div>
    ->c(' Comment 2 ')
    ->region([], 'region with <unsafe> tags')
    ->_()
    ->c(' Comment 3 ')
    ->a()
    ->c(' Comment 4 ')
    ->span(['class' => 'link'], 'Link content')
    ->_()
    ->div(['class' => 'Unsecure "classes"'], 'Unsecure <a href="#">content</a>')
    ->_()
    ->c(' Comment 5 ');

echo $html;
```

This will produce:

```html
<!-- Comment 1 -->
<p class="paragraph">
  some content
  <div class="container">
    this is a simple div
  </div>
</p>
<!-- Comment 2 -->
<region>
  region with &lt;unsafe&gt; tags
</region>
<!-- Comment 3 -->
<a>
  <!-- Comment 4 -->
  <span class="link">
    Link content
  </span>
</a>
<div class="Unsecure &quot;classes&quot;">
  Unsecure &lt;a href=&quot;#&quot;&gt;content&lt;/a&gt;
</div>
<!-- Comment 5 -->
```

## Technical notes

### Tag analysis

```
 The tag name              An attribute                 The content
  |                              |                           |
 ++-+                      +-----+-----+                +----+-----+
 |  |                      |           |                |          |
 
<body class="content node" id="node-123" data-clickable>Hello world!</body>

      |                                               |
      +-----------------------+-----------------------+
                              |
                        The attributes
```
   
The library is built around 3 objects.

* The Tag object that handles the attributes, the tag name and the content,
* The Attributes object that handles the attributes,
* The Attribute object that handles an attribute which is composed of name and its value(s).

The Tag object uses the Attributes object which is, basically, the storage of Attribute objects.
You may use each of these objects individually.

All methods are documented through interfaces and your IDE should be able to autocomplete when needed.

Most methods parameters are [variadics](http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list) and
accept unlimited nested values or array of values.
You can also chain most of the methods.

The allowed type of values can be almost anything. If it's an object, it must implements the `__toString()` method.

#### Examples

Method chaining:

```php
$tag = \drupol\htmltag\HtmlTag::tag('body');
$tag
    ->attr('class', ['FRONT', ['NODE', ['sidebra']], 'node', '  a', '  b  ', [' c']])
    ->replace('sidebra', 'sidebar')
    ->alter(
        function ($values) {
            $values = array_map('strtolower', $values);
            $values = array_unique($values);
            $values = array_map('trim', $values);
            natcasesort($values);

            return $values;
        }
    );
$tag->content('Hello world');

echo $tag; // <body class="a b c front node sidebar">Hello world</body>
```

The following examples will all produce the same HTML.

```php
$tag = \drupol\htmltag\HtmlTag::tag('body');
$tag->attr('class', ['front', ['node', ['sidebar']]]);
$tag->content('Hello world');

echo $tag; // <body class="front node sidebar">Hello world</body>
```

```php
$tag = \drupol\htmltag\HtmlTag::tag('body');
$tag->attr('class', 'front', 'node', 'sidebar');
$tag->content('Hello world');

echo $tag; // <body class="front node sidebar">Hello world</body>
```

```php
$tag = \drupol\htmltag\HtmlTag::tag('body');
$tag->attr('class', ['front', 'node', 'sidebar']);
$tag->content('Hello world');

echo $tag; // <body class="front node sidebar">Hello world</body>
```

```php
$tag = \drupol\htmltag\HtmlTag::tag('body');
$tag->attr('class', 'front node sidebar');
$tag->content('Hello world');

echo $tag; // <body class="front node sidebar">Hello world</body>
```

### Tag object

```php
$tag = \drupol\htmltag\HtmlTag::tag('body');
$tag->attr('class', 'front');
$tag->content('Hello world');

echo $tag; // <body class="front">Hello world</body>
```

### Attributes object

```php
$attributes = \drupol\htmltag\HtmlTag::attributes();
$attributes->append('class', 'a', 'b', 'c');
$attributes->append('id', 'htmltag');

// Hence the trailing space before the class attribute.
echo $attributes; //  class="a b c" id="htmltag"
```

### Attribute object

```php
$attribute = \drupol\htmltag\HtmlTag::attribute('class', 'section');

echo $attribute; // class="section"
```

## Dependency injection and extensions

Thanks to the factories provided in the library, it is possible to inject different objects in place of the default ones.

Ex: You want to have a special handling for the "class" attribute.

```php
class CustomAttribute extends \drupol\htmltag\Attribute\Attribute {
  /**
   * {@inheritdoc}
   */
  protected function preprocess(array $values, $name = NULL) {
    // Special handling for "class" attribute.
    if ('class' === $name) {
      // Remove duplicated values.
      $values = array_unique($values);

      // Trim values.
      $values = array_map('trim', $values);

      // Sort values.
      natcasesort($values);
    }

    return $values;
  }
}

class CustomAttributeFactory extends \drupol\htmltag\Attribute\AttributeFactory {
    protected $attribute_classname = CustomAttribute::class;
}

$tag = \drupol\htmltag\Tag\TagFactory::build(
    'p',
    [],
    false,
    CustomAttributeFactory::class
);

// Add a class attribute and some values.
$tag->attr('class', 'e', 'c', ['a', 'b'], 'd', 'a', ' f ');
// Add a random attribute and the same values.
$tag->attr('data-original', 'e', 'c', ['a', 'b'], 'd', 'a', ' f ');

echo $tag; // <p class="a b c d e f" data-original="e c a b d a  f "/>
```

The same mechanism goes for Attributes and Tag classes.

## Security

To avoid security issues, every printed objects are escaped.

If objects are used as input and if they implement the `__toString()` method, they will be converted to string.
It's up to the user to make sure that they print **unsafe** output so they are not escaped twice.

## Code quality, tests and benchmarks

Every time changes are introduced into the library, [Travis CI](https://travis-ci.org/drupol/htmltag/builds) run the tests and the benchmarks.

The library has tests written with [PHPSpec](http://www.phpspec.net/).
Feel free to check them out in the `spec` directory. Run `composer phpspec` to trigger the tests.

[PHPBench](https://github.com/phpbench/phpbench) is used to benchmark the library, to run the benchmarks: `composer bench`

[PHPInfection](https://github.com/infection/infection) is used to ensure that your code is properly tested, run `composer infection` to test your code.

## Contributing

Feel free to contribute to this library by sending Github pull requests. I'm quite reactive :-)
