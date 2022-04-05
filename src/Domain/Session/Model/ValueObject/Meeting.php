<?php

namespace App\Domain\Session\Model\ValueObject;

use Assert\Assertion;

class Meeting
{
    private string $url;
    private string $hostUrl;

    protected function __construct() {}

    public static function fromString(string $url, string $hostUrl): self
    {
        Assertion::url($url, 'Not a valid url');
        Assertion::url($hostUrl, 'Not a valid url');

        $meeting = new self();
        $meeting->url = $url;
        $meeting->hostUrl = $hostUrl;

        return $meeting;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function hostUrl(): string
    {
        return $this->hostUrl;
    }
}