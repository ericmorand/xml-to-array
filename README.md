# Plain and simple XML-to-array converter [![Build Status][travis-image]][travis-url]

This package provides a very simple converter to convert an XML string to an array. No attributes support, no complex logic, just a plain and simple converter that just works.

## Installation

```bash
composer require ericmorand/xml-to-array
```

## Usage

```php
<?php

use EricMorand\XMLToArray;

$converter = new XMLToArray\Converter();
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<foo>
    <prop0/>
    <prop1>foo</prop1>
    <prop2><![CDATA[foo]]></prop2>
    <prop3>
        <prop0/>
        <prop1>foo</prop1>
        <prop2><![CDATA[foo]]></prop2>
    </prop3>
</foo>";

$array = $converter->convertXML($xml);
```

By running this code, `$array` would contain:

```php
[
    'prop0' => null,
    'prop1' => 'foo',
    'prop2' => 'foo',
    'prop3' => [
        'prop0' => null,
        'prop1' => 'foo',
        'prop2' => 'foo'
    ]
]
```

[travis-image]: https://travis-ci.org/ericmorand/xml-to-array.svg?branch=master
[travis-url]: https://travis-ci.org/ericmorand/xml-to-array
