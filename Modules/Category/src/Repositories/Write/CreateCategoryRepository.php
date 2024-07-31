<?php

namespace Modules\Category\src\Repositories\Write;

use Modules\Category\App\Models\Category;
use Modules\Category\src\Commands\Create\CreateCategoryCommand;
use Modules\Category\src\Contracts\Repositories\CreateCategoryContract;

class CreateCategoryRepository implements CreateCategoryContract {

    public function create(
        CreateCategoryCommand $command
    ) : ? object{
        return Category::query()->create($command->arr());
    }

}
