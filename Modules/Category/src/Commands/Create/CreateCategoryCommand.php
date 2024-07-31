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
        return htmlentities($this->name, ENT_QUOTES, 'UTF-8');
    }

    public function getSlug(): string{
        return Helper::slugGenerate($this->name);
    }

    public function getStatus(): bool{
        return $this->status;
    }

}
