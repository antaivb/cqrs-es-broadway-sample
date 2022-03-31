<?php

namespace App\Domain\Session\Model\ValueObject;

use Assert\Assertion;

class Meeting
{
    private string $url;
    private string $hostUrl;

    protected function __construct(string $url, string $hostUrl)
    {
        $this->url = $url;
        $this->hostUrl = $hostUrl;
    }

    public static function fromString(string $url, string $hostUrl): self
    {
        Assertion::url($url, 'Not a valid url');
        Assertion::url($hostUrl, 'Not a valid url');

        return new self($url, $hostUrl);
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