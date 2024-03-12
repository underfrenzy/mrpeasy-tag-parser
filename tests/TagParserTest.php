<?php


use Ivankrotov\MrpeasyParserTag\TagParser;
use PHPUnit\Framework\TestCase;

class TagParserTest extends TestCase
{
    public function testEmptyString()
    {
        $result = (new TagParser())->parseTextForTags("");
        $this->assertEquals([], $result);
    }

    public function testOnlyOpenTagPresent()
    {
        $result = (new TagParser())->parseTextForTags("[tagName:description]");
        $this->assertEquals([], $result);
    }

    public function testOnlyCloseTagPresent()
    {
        $result = (new TagParser())->parseTextForTags("[/tagName]");
        $this->assertEquals([], $result);
    }

    public function testMissingDescription()
    {
        $result = (new TagParser())->parseTextForTags("[tagName:][/tagName]");
        $this->assertEquals([], $result);
    }

    public function testParseTextForTagsInLowerCase(): void
    {
        $text = "[tag:description]data[/tag]";
        $expectedResult = [
            'tag' => [
                'description' => 'description',
                'data' => 'data'
            ]
        ];

        $result = (new TagParser())->parseTextForTags($text);

        $this->assertEquals($expectedResult, $result);
    }

    public function testParseTextForTags(): void
    {
        $text = "[TAG:description]data[/TAG]";
        $expectedResult = [
            'TAG' => [
                'description' => 'description',
                'data' => 'data'
            ]
        ];

        $result = (new TagParser())->parseTextForTags($text);

        $this->assertEquals($expectedResult, $result);
    }

    public function testParseTextForNoTags(): void
    {
        $text = "This is a test without any tags";
        $expectedResult = [];

        $result = (new TagParser())->parseTextForTags($text);

        $this->assertEquals($expectedResult, $result);
    }

    public function testParseTextForMultipleTags(): void
    {
        $text = "[TAG1:Test description 1]Data1[/TAG1][TAG2:Test description 2]Data2[/TAG2]";
        $expectedResult = [
            'TAG1' => [
                'description' => 'Test description 1',
                'data' => 'Data1'
            ],
            'TAG2' => [
                'description' => 'Test description 2',
                'data' => 'Data2'
            ]
        ];

        $result = (new TagParser())->parseTextForTags($text);

        $this->assertEquals($expectedResult, $result);
    }


}
