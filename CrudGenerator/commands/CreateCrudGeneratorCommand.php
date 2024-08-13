<?php

namespace CrudGenerator\commands;

use CrudGenerator\Enums\StatusEnum;

class CreateCrudGeneratorCommand{

    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $desc,
        public readonly string $table_name,
        public readonly array $support,
        public readonly StatusEnum $status,
    ){}

    public function getName() : string{
        return $this->name;
    }

    public function slug() : string{
        return $this->slug;
    }

    public function getDesc() : mixed{
        return $this->desc;
    }

    public function getTableName() : string{
        return $this->table_name;
    }

    public function getSupport() : array{
        return $this->support;
    }

    public function getStatus() : StatusEnum{
        return $this->status;
    }

}
