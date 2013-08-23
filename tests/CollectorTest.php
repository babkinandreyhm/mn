<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 22.08.13
 * Time: 11:40
 * To change this template use File | Settings | File Templates.
 */

include '../autoload.php';

class CollectorTest extends PHPUnit_Framework_TestCase
{
    public function testGetSum()
    {
        $c = new \collect\Collector();
        $this->assertEquals(5, $c->getSum(2 ,3));
    }

    public function testGetDataObject()
    {
        $c = new \collect\Collector('<root>
                                        <a>1.9</a>
                                        <b>1.9</b>
                                    </root>');
        $this->assertEquals('SimpleXMLElement', get_class($c->getDataObject()));
    }

    public function testGetDate()
    {
        $c = new \collect\Collector();
        $this->assertEquals('24.08.2013', $c->getDate());
    }

    //this is a example test for protected methods
    public function testCreateCurrencyArray()
    {
        $method = new ReflectionMethod(
            '\collect\Collector', 'getCurrencies'
        );
        $method->setAccessible(TRUE);

        $c = new \collect\Collector('<ValCurs Date="22.08.2013" name="Foreign Currency Market">
                                        <Valute ID="R01010">
                                        <NumCode>036</NumCode>
                                        <CharCode>AUD</CharCode>
                                        <Nominal>1</Nominal>
                                        <Name>Австралийский доллар</Name>
                                        <Value>29,7687</Value>
                                        </Valute>
                                        <Valute ID="R01020A">
                                        <NumCode>944</NumCode>
                                        <CharCode>AZN</CharCode>
                                        <Nominal>1</Nominal>
                                        <Name>Азербайджанский манат</Name>
                                        <Value>42,0690</Value>
                                        </Valute>
                                    </ValCurs>');
        $this->assertEquals(
            [
                '036' => [
                    'NumCode' => '036',
                    'CharCode' => 'AUD',
                    'Nominal' => '1',
                    'Name' => 'Австралийский доллар',
                    'Value' => '29,7687'
                ],
                '944' => [
                    'NumCode' => '944',
                    'CharCode' => 'AZN',
                    'Nominal' => '1',
                    'Name' => 'Азербайджанский манат',
                    'Value' => '42,0690'
                ]
            ],
            $method->invoke($c)
        );
    }
}