<?php

declare(strict_types=1);

namespace App\Interfaces;

interface NewsServiceInterface
{
    public function fetch(): array;
}
