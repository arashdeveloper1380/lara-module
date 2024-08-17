<?php

namespace Modules\Category\src\Contracts\OutBox;

use Modules\Category\src\Commands\OutBox\CreateCategoryOutBoxCommand;

interface CreateCategoryOutBoxContract{

    public function store(
        CreateCategoryOutBoxCommand $command
    );

}
