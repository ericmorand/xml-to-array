<?php
/**
 * Created by PhpStorm.
 * User: ericmorand
 * Date: 27.02.19
 * Time: 21:13
 */

namespace EricMorand\XMLToArray;

class Converter
{
    /**
     * @param $xml
     * @return array
     */
    public function convertXML($xml)
    {
        $xmlElement = simplexml_load_string($xml);

        return $this->convertXMLElement($xmlElement);
    }

    /**
     * @param \SimpleXMLElement $XMLElement
     * @return array
     */
    public function convertXMLElement(\SimpleXMLElement $XMLElement)
    {
        $result = array();

        foreach ($XMLElement->children() as $key => $value) {
            if (array_key_exists($key, $result)) {
                if (!isset($extract[$key][0])) {
                    $tmp_extract = $result[$key];
                    $result[$key] = array();
                    $result[$key][0] = $tmp_extract;
                } else {
                    $result[$key] = (array)$result[$key];
                }
            }

            if ($value->count()) {
                if (isset($result[$key]) && is_array($result[$key])) {
                    $result[$key][] = $this->convertXMLElement($value);
                } else {
                    $result[$key] = $this->convertXMLElement($value);
                }
            } else {
                if (isset($result[$key]) && is_array($result[$key])) {
                    $result[$key][] = empty(strval($value)) ? null : strval($value);
                } else {
                    $result[$key] = empty(strval($value)) ? null : strval($value);
                }
            }
        }

        return $result;
    }
}