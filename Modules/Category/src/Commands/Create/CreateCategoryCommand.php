<?php

namespace Modules\Category\src\Commands\Create;

use Modules\Category\src\Helper;

class CreateCategoryCommand{

    public function __construct(
        public readonly string  $name,
        public readonly string  $slug,
        public readonly bool    $status,
    ){}

    public function getName(): string{
        return $this->name;
    }

    public function getSlug(): string{
        return $this->name;
    }

    public function getStatus(): bool{
        return $this->status;
    }

    public function arr() :array{
        return [
            "name"      => htmlentities($this->name, ENT_QUOTES, 'UTF-8'),
            "slug"      => Helper::slugGenerate($this->slug),
            "status"    => (bool) $this->status
        ];
    }



}
