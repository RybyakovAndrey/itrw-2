<?php


enum FeedbackStatus {
    case InProgress;
    case Resolved;
    case Rejected;
}

class Feedback
{
    private string $name;
    private string $email;
    private string $title;
    private string $message;
    private FeedbackStatus $status;

    public function __construct(string $name, string $email, string $title, string $message) {
        $this->name = $name;
        $this->email = $email;
        $this->title = $title;
        $this->message = $message;
    }
    public function send() : bool {
        // Логика отправки в БД, например
        // этот метод в принципе можно было даже определить в User
        $this->setStatus(FeedbackStatus::InProgress);
        return 0;
    }

    public function setStatus(FeedbackStatus $status) {
        $this->status = $status;
    }

    public function getStatus(): FeedbackStatus
    {
        return $this->status;
    }

    public function getFullInfo() {
        return "Тема: $this->title от $this->name ($this->email)\n$this->message";
    }
}

