<?php

namespace Modules\Category\src\Commands\OutBox;

class CreateCategoryOutBoxCommand{

    public function __construct(
        public readonly string|int $type,
        public readonly mixed $payload,
        public readonly ?string $processed_at,
    ){}

    public function getType() : string|int{
        return $this->type;
    }

    public function getPayload() : mixed{
        return $this->payload;
    }

    public function getProcessed_at() : string|int|null{
        return $this->processed_at;
    }

    public function arr() : array{
        return [
            'type'          => $this->type,
            'payload'       => $this->payload,
            'processed_at'  => $this->processed_at,
        ];
    }

    public function deserialize() : self {
        return new self (
            $this->type,
            $this->payload,
            $this->processed_at,
        );
    }

}
