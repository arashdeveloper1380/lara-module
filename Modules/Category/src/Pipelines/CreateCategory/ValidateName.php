<?php

namespace Modules\Category\src\Pipelines\CreateCategory;
use Closure;
use Illuminate\Support\Facades\Validator;

class ValidateName{

    public function handle($request, Closure $next){
        $validated = Validator::make($request, [
           'name' => 'required',
        ]);

        if($validated->fails()){
            throw new \Exception($validated->messages()->first());
        }

        return $next($request);
    }

}
