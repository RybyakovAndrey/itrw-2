<?php

namespace App;

class Comment
{
    private int $id;
    private int $id_author;
    private int $id_article;
    private string $text;
    public function __construct(int $id, int $id_author, int $id_article, string $text){
        $this->id = $id;
        $this->id_author = $id_author;
        $this->id_article = $id_article;
        $this->text = $text;
    }
}