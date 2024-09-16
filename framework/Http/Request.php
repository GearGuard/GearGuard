<?php

namespace GearGurd\Framework\Http;

class Request
{
    public function __construct(
        public array $getParams,
        public array $postParams,
        public array $cookieParams,
        public array $files,
        public array $server,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }
}
