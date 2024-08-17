<?php

namespace Modules\Category\src\Commands\Create;

use Modules\Category\src\Helper;

final class CreateCategoryCommand{

    public function __construct(
        public readonly string  $name,
        public readonly string  $slug,
        public readonly bool    $status,
        public readonly ?string $image
    ){}

    public function getName() : string{
        return $this->name;
    }

    public function getSlug() : string{
        return $this->name;
    }

    public function getStatus() : bool{
        return $this->status;
    }

    public function getImagePath() : ? string{
        return $this->image;
    }

    public function arr() :array{
        return [
            "name"      => htmlentities($this->name, ENT_QUOTES, 'UTF-8'),
            "slug"      => Helper::slugGenerate($this->slug),
            "status"    => (bool) $this->status,
            "image"     => $this->image
        ];
    }

    public function deserialize(array $data) : self{
        return new self(
            $data['name'],
            $data['slug'],
            $data['status'],
            $data['image']
        );
    }

}
