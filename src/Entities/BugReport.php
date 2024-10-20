<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Entities;

class BugReport extends Entity
{
    private int $id;
    private string $report_type;
    private string $email;
    private string $link;
    private string $message;
    private string $created_at;

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getReportType(): string
    {
        return $this->report_type;
    }

    public function setReportType(string $report_type): BugReport
    {
        $this->report_type = $report_type;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): BugReport
    {
        $this->email = $email;
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): BugReport
    {
        $this->link = $link;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): BugReport
    {
        $this->message = $message;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function toArray(): array
    {
        return [
            'report_type' => $this->report_type,
            'email' => $this->email,
            'message' => $this->message,
            'link' => $this->link,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}
