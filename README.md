# HTMLTag

A library for creating HTML tags.

# Examples

```php
/** @var \drupol\htmltag\Tag $meta */
$meta = \drupol\htmltag\Tag::meta();
$meta->attr('name')->set('author');
$meta->attr('content')->set('Pol Dellaiera');

/** @var \drupol\htmltag\Tag $tag */
$title = \drupol\htmltag\Tag::h1();
$title->attr('class')->set('title');
$title->content(['Welcome to HTMLTag']);

/** @var \drupol\htmltag\Tag $paragraph */
$paragraph = \drupol\htmltag\Tag::p();
$paragraph->attr('class')->append('section')->append('desc');
$paragraph->content(['This library helps you create HTML.']);
$paragraph->attr('class')->remove('section')->replace('desc', 'description');

$footer = 'Thanks for using it!';

/** @var \drupol\htmltag\Tag $body */
$body = \drupol\htmltag\Tag::body();
$body->content([$title, $paragraph, $footer]);

echo $meta . $body;
```

Will print:

```html
<meta content="Pol Dellaiera" name="author"/>
<body>
  <h1 class="title">Welcome to HTMLTag</h1>
  <p class="description">This library helps you create HTML.</p>
  Thanks for using it!
</body>
```
