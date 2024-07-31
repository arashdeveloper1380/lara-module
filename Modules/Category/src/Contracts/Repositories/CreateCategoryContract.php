<?php

namespace Modules\Category\src\Contracts\Repositories;

use Modules\Category\src\Commands\Create\CreateCategoryCommand;

interface CreateCategoryContract{

    public function create(CreateCategoryCommand $command) : ? object;

}
