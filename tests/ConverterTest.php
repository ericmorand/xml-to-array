<?php
/**
 * Created by PhpStorm.
 * User: ericmorand
 * Date: 27.02.19
 * Time: 21:13
 */

namespace EricMorand\XMLToArray;

use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function xml()
    {
        return [
            [
                "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<foo>
    <prop0/>
    <prop1>foo</prop1>
    <prop2><![CDATA[foo]]></prop2>
    <prop3>
        <prop0/>
        <prop1>foo</prop1>
        <prop2><![CDATA[foo]]></prop2>
    </prop3>
</foo>
"
            ]
        ];
    }

    /**
     * @dataProvider xml
     * @param string $xml
     */
    public function testConvertXML($xml)
    {
        $converter = new Converter();

        $expected = [
            'prop0' => null,
            'prop1' => 'foo',
            'prop2' => 'foo',
            'prop3' => [
                'prop0' => null,
                'prop1' => 'foo',
                'prop2' => 'foo'
            ]
        ];

        $this->assertSame($expected, $converter->convertXML($xml));
    }

    /**
     * @dataProvider xml
     * @param string $xml
     */
    public function testConvertXMLElement($xml)
    {
        $converter = new Converter();

        $xmlElement = simplexml_load_string($xml);
        $expected = [
            'prop0' => null,
            'prop1' => 'foo',
            'prop2' => 'foo',
            'prop3' => [
                'prop0' => null,
                'prop1' => 'foo',
                'prop2' => 'foo'
            ]
        ];

        $this->assertSame($expected, $converter->convertXMLElement($xmlElement));
    }

    /**
     * @see https://github.com/ericmorand/xml-to-array/issues/1
     */
    function testSupportMoreThanTwoCHildren()
    {
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<foo>
    <child>
        <prop0>foo1</prop0>
    </child>
    <child>
        <prop0>foo2</prop0>
    </child>
    <child>
        <prop0>foo3</prop0>
    </child>
</foo>";

        $converter = new Converter();

        $expected = [
            'child' => [
                [
                    'prop0' => 'foo1'
                ],
                [
                    'prop0' => 'foo2'
                ],
                [
                    'prop0' => 'foo3'
                ]
            ]
        ];

        $this->assertSame($expected, $converter->convertXML($xml));
    }
}