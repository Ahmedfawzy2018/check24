<?php

namespace App\Service;

final class Slugfy
{
    public static function create(string $name): string
    {
        $name = iconv("utf-8", "us-ascii//translit//ignore", $name);
        $name = str_replace("'", "", $name);
        $name = preg_replace("~[^a-z0-9]+~ui", '-', $name);
        $name = trim($name, '-');
        $name = mb_strtolower($name, "utf-8");
        return $name;
    }
}
