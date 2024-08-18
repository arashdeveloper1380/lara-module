<?php

namespace CrudGenerator\commands;

use CrudGenerator\Enums\StatusEnum;

final readonly class CreateCrudGeneratorCommand{

    public function __construct(
        public string     $name,
        public string     $slug,
        public string     $desc,
        public string     $table_name,
        public array      $support,
        public StatusEnum $status,
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

    public function arr() :array{
        return [
            'name'      => $this->name,
            'slug'      => $this->slug,
            'desc'      => $this->desc,
            'tableName' => $this->table_name,
            'support'   => $this->support,
            'status'    => $this->status,
        ];
    }

    public function deserialize(array $data) : self{
        return new self(
            $data['name'],
            $data['slug'],
            $data['desc'],
            $data['tableName'],
            $data['support'],
            $data['status']
        );
    }

}
