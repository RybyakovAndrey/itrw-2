<?php

class Review
{
    private User $user;
    private string $text;
    private bool $status;
    private $time;

    public function __construct(User $user, string $text)
    {
        $this->user = $user;
        $this->text = $text;
        $this->time = time();
    }
    public function applyFeedback($status) {
        $this->status = $status;
    }
}