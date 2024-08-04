<?php

namespace Modules\Category\src\Pipelines\CreateCategory;
use Closure;
use Illuminate\Support\Facades\Validator;

class ValidateImage{

    public function handle($request, Closure $next){
        $validated = Validator::make($request, [
           'image' => 'nullable|file|max:2048',
        ]);

        if($validated->fails()){
            throw new \Exception($validated->messages()->first());
        }

        return $next($request);
    }

}
