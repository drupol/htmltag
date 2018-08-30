[![Codacy Badge](https://api.codacy.com/project/badge/Grade/488a8e933d4b4acfa0f85254125a32f6)](https://app.codacy.com/app/drupol/htmltag?utm_source=github.com&utm_medium=referral&utm_content=drupol/htmltag&utm_campaign=Badge_Grade_Dashboard)
[![Build Status](https://travis-ci.org/drupol/htmltag.svg?branch=1.x)](https://travis-ci.org/drupol/htmltag)[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/drupol/htmltag/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/drupol/htmltag/?branch=1.x)[![Code Coverage](https://scrutinizer-ci.com/g/drupol/htmltag/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/drupol/htmltag/?branch=1.x)

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
$paragraph->attr('class', 'section')->append('desc');
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
