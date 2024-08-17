<?php

namespace Modules\Category\src\OutBoxRepository\Write;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Category\App\Models\CategoryOutBox;
use Modules\Category\src\Commands\OutBox\CreateCategoryOutBoxCommand;
use Modules\Category\src\Contracts\OutBox\CreateCategoryOutBoxContract;

class CreateCategoryOutBoxRepository implements CreateCategoryOutBoxContract {

    public function store(
        CreateCategoryOutBoxCommand $command
    ){
        DB::beginTransaction();
        try {

            CategoryOutBox::query()->create($command->arr());
            DB::commit();

        }catch (\Exception $exception){

            DB::rollBack();
            Log::error('Failed to create category outbox: '.$exception->getMessage());

        }
    }

}
