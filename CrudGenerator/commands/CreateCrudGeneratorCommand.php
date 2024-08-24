<?php

namespace CrudGenerator\commands;

use CrudGenerator\Enums\DeveloperModeEnum;
use CrudGenerator\Enums\StatusEnum;

final class CreateCrudGeneratorCommand{

    public function __construct(
        public string     $name,
        public string     $slug,
        public string     $desc,
        public string     $table_name,
        public array      $support,
        public StatusEnum $status,
        public DeveloperModeEnum $developer_mode
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

    public function developerMode() : DeveloperModeEnum{
        return $this->developer_mode;
    }

    public function arr() :array{
        return [
            'name'      => $this->name,
            'slug'      => $this->slug,
            'desc'      => $this->desc,
            'table_name' => $this->table_name,
            'support'   => $this->support,
            'status'    => $this->status,
            'developer_mode' => $this->developer_mode
        ];
    }

    public function deserialize(array $data) : self{
        return new self(
            $data['name'],
            $data['slug'],
            $data['desc'],
            $data['table_name'],
            $data['support'],
            $data['status'],
            $data['developer_mode']
        );
    }

}
