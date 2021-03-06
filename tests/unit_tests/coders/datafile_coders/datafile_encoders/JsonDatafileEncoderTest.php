<?php

/*
 * This file is part of the DataCoder package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Exorg\DataCoder;

use Exorg\Decapsulator\ObjectDecapsulator;

/**
 * JsonDatafileEncoderTest.
 * PHPUnit test class for JsonDatafileEncoder class.
 *
 * @package DataCoder
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2015 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ExOrg/php-data-coder
 */
class JsonDatafileEncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Encoded data format.
     */
    const DATA_FORMAT_JSON = 'json';

    /**
     * Helper for handling data file fixtures.
     *
     * @var DataFileFixturesHelper
     */
    private static $dataFileFixturesHelper = null;

    /**
     * Instance of tested class.
     *
     * @var JsonDatafileEncoder
     */
    private $jsonDatafileEncoder;

    /**
     * Test Exorg\DataCoder\JsonDatafileEncoder class
     * has been created.
     */
    public function testJsonDatafileEncoderClassExists()
    {
        $this->assertTrue(
            class_exists('Exorg\DataCoder\JsonDatafileEncoder')
        );
    }

    /**
     * Test if encodeFile function
     * has been defined.
     */
    public function testEncodeFileFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Exorg\DataCoder\JsonDatafileEncoder',
                'encodeFile'
            )
        );
    }

    /**
     * Test encodeFile function throws exception
     * when type of data is incorrect.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testEncodeFileWithIncorrectData()
    {
        $dataFilePath = self::$dataFileFixturesHelper->buildCreatedFilePath('data');
        $data = 1024;

        $this->jsonDatafileEncoder->encodeFile($data, $dataFilePath);
    }

    /**
     * Test encodeFile encodes data properly
     * and saves it to the proper file.
     */
    public function testEncodeFile()
    {
        $dataFilePath = self::$dataFileFixturesHelper->buildCreatedFilePath('data.json');
        $data = self::$dataFileFixturesHelper->loadDecodedData();

        $this->jsonDatafileEncoder->encodeFile($data, $dataFilePath);

        $expectedResult = self::$dataFileFixturesHelper->loadEncodedData();
        $actualResult = file_get_contents($dataFilePath);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass()
    {
        self::$dataFileFixturesHelper = new DataFileFixturesHelper();
        self::$dataFileFixturesHelper->setDataFormat(self::DATA_FORMAT_JSON);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->jsonDatafileEncoder = new JsonDatafileEncoder();
    }
}
