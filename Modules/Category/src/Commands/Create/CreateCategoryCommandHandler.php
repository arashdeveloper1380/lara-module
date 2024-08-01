<?php

namespace Modules\Category\src\Commands\Create;

use Modules\Category\src\Contracts\Repositories\CreateCategoryContract;

class CreateCategoryCommandHandler{
    public function __construct(
        protected CreateCategoryContract $contract
    ){}

    public function handle(CreateCategoryCommand $command){
        return $this->contract->create(
            $command
        );
    }
}
