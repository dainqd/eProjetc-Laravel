<?php

namespace App\Enums;

enum ResourceType :int
{
    case Textbook = 1;
    case Video = 2;
    case Audio = 3;
    case Website = 4;
    case Other = 5;

    public function toSelectArray(): array
    {
        return [
            'Textbook' => self::Textbook,
            'Video' => self::Video,
            'Audio' => self::Audio,
            'Website' => self::Website,
            'Other' => self::Other,
        ];
    }
}
