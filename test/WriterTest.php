<?php

define("ROOT_DIR", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "src");
define("TEST_DIR", __DIR__);

use PHPUnit\Framework\TestCase;
use KrzysztofSobolewskiRekrutacjaHRtec\Entity\FeedItem;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss\Reader;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss\Converter;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv\Writer;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv\Utils as CsvUtils;
use KrzysztofSobolewskiRekrutacjaHRtec\Exception\FieldDoesNotExistException;
use Feed;

final class WriterTest extends TestCase
{
    private $outputPath = TEST_DIR . DIRECTORY_SEPARATOR . 'outputTest.csv';
    private $feedUrl = "http://feeds.bbci.co.uk/news/rss.xml";

    private function writeItem($feedItem, $appendMode)
    {
        $writer = new Writer(
            $this->outputPath,
            CsvUtils::getHeader(),
            $appendMode);
        $writer->write($feedItem);
        $writer->close();
    }

    private function makeXmlStub()
    {
        $testFile = TEST_DIR . DIRECTORY_SEPARATOR . "feeds.bbci.co.uk_news_rss.xml";
        $data = file_get_contents($testFile);
        $this->assertNotNull($data);

        $xmlElement = new SimpleXMLElement($data);
        $this->assertNotNull($xmlElement);

        $stubFeed = $this->createMock(Feed::class);
        $stubFeed->method('load')->willReturn($xmlElement->channel);

    }

    public function testReader(): void
    {
        $this->makeXmlStub();
        $reader = new Reader($this->feedUrl);
        foreach ($reader->read() as $item) {
            $this->assertNotEquals($item->title, '');
            $this->assertNotEquals($item->pubDate, '');
        }
    }

    public function testConverter(): void
    {
        $this->makeXmlStub();
        $reader = new Reader($this->feedUrl);
        foreach ($reader->read() as $item) {
            $item->description .= " https://example.com <b>In Bold</b>";
            $feedItem = Converter::convertToFeedItem($item);
            $this->assertNotEquals($item->title, '');
            $this->assertNotEquals($item->pubDate, '');
            $this->assertNotNull($feedItem);;
            $this->assertInstanceOf(FeedItem::class, $feedItem, "not an instance of FeedItem");
            $this->assertTrue(strpos(strval($item->description), 'https://example.com') !== FALSE);
            $this->assertTrue(strpos($feedItem->description, '<b>') === FALSE);
            $this->assertTrue(strpos(strval($item->description), 'https://example.com') !== FALSE);
            $this->assertTrue(strpos($feedItem->description, '<b>') === FALSE);
        }
    }

    public function testWriterNotAppend(): void
    {
        if (file_exists($this->outputPath)) {
            unlink($this->outputPath);
        }
        $header = CsvUtils::getHeader();
        $feedItem = new FeedItem(
            'Test Item',
            'Test Item Desc',
            "https://example.com",
            "Wed, 28 Oct 2020 15:38:09 GMT",
            "Chris");

        $this->writeItem($feedItem, false);
        $data = CsvUtils::readCsvFromFile($this->outputPath, $header);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertEquals(count($data), 1);
        $this->assertEquals($data[0][0], $feedItem->title);
    }

    public function testWriterAppend(): void
    {
        if (file_exists($this->outputPath)) {
            unlink($this->outputPath);
        }
        $header = CsvUtils::getHeader();
        $feedItem1 = new FeedItem(
            'Test Item 1',
            'Test Item Desc 1',
            "https://example.com/1",
            "Wed, 28 Oct 2020 15:38:09 GMT",
            "Chris");
        $feedItem2 = new FeedItem(
            'Test Item 2',
            'Test Item Desc 2',
            "https://example.com/2",
            "Wed, 28 Oct 2020 15:38:09 GMT",
            "Chris");

        $this->writeItem($feedItem1, false);
        $this->writeItem($feedItem2, true);

        $data = CsvUtils::readCsvFromFile($this->outputPath, $header);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertEquals(count($data), 2);
        $this->assertEquals($data[0][0], $feedItem2->title);
        $this->assertEquals($data[1][0], $feedItem1->title);
    }

    public function testFeedItemException()
    {
        $feedItem = new FeedItem(
            'Test Item Exc',
            'Test Item Desc 2',
            "https://example.com/2",
            "Wed, 28 Oct 2020 15:38:09 GMT",
            "Chris");
        $this->expectException(FieldDoesNotExistException::class);
        $feedItem->non_existent_field = 'nothing';
    }

}