<?php

namespace App\DTO;

class ErrorResponseContent
{
    public string $type;
    public string $title;
    public string $detail;

    /**
     * @var array<object>
     */
    public array $violations;
}
