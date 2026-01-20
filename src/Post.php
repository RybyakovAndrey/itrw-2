<?php

namespace App;

class Post
{
    private string $uuid;
    private string $author_uuid;
    private string $title;
    private string $text;
    public function __construct(string $uuid, string $author_uuid, string $title, string $text)
    {
        $this->uuid = $uuid;
        $this->author_uuid = $author_uuid;
        $this->title = $title;
        $this->text = $text;
    }

}