<?php

namespace Ivankrotov\MrpeasyParserTag;

class TagParser
{
    // [TAG_NAME:description]data[/TAG_NAME]
    function parseTextForTags(string $text): array
    {
        $result = [];

        preg_match_all('#\[(\w+):(.+?)\](.+?)\[/\\1\]#', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            [ $fullMatch, $tagName, $description, $data ] = $match;

            $result[$tagName] = [
                'description' => $description,
                'data' => $data,
            ];
        }

        return $result;
    }
}
