<?php

namespace App\Support;

class Payload
{
    public function __construct(
        public readonly string $id,
        public readonly string $topic,
        public readonly array $pattern,
        public readonly array $data,
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            id: $payload['id'],
            topic: $payload['topic'],
            pattern: $payload['pattern'],
            data: $payload['data'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'topic' => $this->topic,
            'pattern' => $this->pattern,
            'data' => $this->data,
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function toJson(): string
    {
        return $this->__toString();
    }
}
