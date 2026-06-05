<?php

namespace App\Support;

use ArPHP\I18N\Arabic;

class ArabicText
{
    private static ?Arabic $arabic = null;

    private static function arabic(): Arabic
    {
        return self::$arabic ??= new Arabic();
    }

    public static function containsArabic(?string $text): bool
    {
        if ($text === null || $text === '') {
            return false;
        }

        return (bool) preg_match(
            '/[\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]/u',
            $text
        );
    }

    /**
     * Shape Arabic glyphs for PDF renderers (e.g. DomPDF) that do not join letters.
     */
    public static function forPdf(?string $text): ?string
    {
        if ($text === null || $text === '') {
            return $text;
        }

        if (!self::containsArabic($text)) {
            return $text;
        }

        return self::arabic()->utf8Glyphs($text);
    }
}
