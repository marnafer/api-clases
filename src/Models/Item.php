<?php
declare(strict_types=1);

namespace App\Models;

class Example
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromArray(array $data): self
    {
        return new self((int)($data['id'] ?? 0), (string)($data['name'] ?? ''));
    }

    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name];
    }
}