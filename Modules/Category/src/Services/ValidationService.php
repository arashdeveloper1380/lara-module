<?php

namespace Modules\Category\src\Services;

use Illuminate\Pipeline\Pipeline;
use Modules\Category\src\Pipelines\CreateCategory\ValidateImage;
use Modules\Category\src\Pipelines\CreateCategory\ValidateName;
use Modules\Category\src\Pipelines\CreateCategory\ValidateStatus;

class ValidationService{
    public function validate(array $data){
        return
        app(Pipeline::class)
            ->send($data)
            ->through([
                ValidateName::class,
                ValidateStatus::class,
                ValidateImage::class,
            ])
            ->then(function ($data){
                return $data;
            });
    }

}
