<?php

namespace GearGurd\Framework\Http;

class Response
{
    public function __construct(
        private ?string $content = '',
        private int     $status = 200,
        private array   $header = []
    )
    {

    }

    public function send(): void
    {
        echo $this->content;
    }
}