<?php

namespace App;

class Article
{
    private int $article_id;
    private int $id_author;
    private string $title;
    private string $text;
    public function __construct(int $article_id, int $id_author, string $title, string $text)
    {
        $this->$article_id = $article_id;
        $this->id_author = $id_author;
        $this->title = $title;
        $this->text = $text;
    }

}