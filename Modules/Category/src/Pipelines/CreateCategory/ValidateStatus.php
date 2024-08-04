<?php

namespace Modules\Category\src\Pipelines\CreateCategory;
use Closure;
use Illuminate\Support\Facades\Validator;

class ValidateStatus{

    public function handle($request, Closure $next){
        $validated = Validator::make($request, [
           'status' => 'required',
        ]);

        if($validated->fails()){
            throw new \Exception($validated->messages()->first());
        }

        return $next($request);
    }

}
