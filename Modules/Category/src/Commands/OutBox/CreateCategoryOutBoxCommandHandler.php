<?php

namespace Modules\Category\src\Commands\OutBox;

use Modules\Category\src\Contracts\OutBox\CreateCategoryOutBoxContract;

class CreateCategoryOutBoxCommandHandler{

    public function __construct(
        protected CreateCategoryOutBoxContract $contract
    ){}
    public function handle(CreateCategoryOutBoxCommand $command) :void{
        $this->contract->store(
            $command
        );
    }

}
