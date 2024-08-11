<?php

$modules = [];

foreach(getActiveModules() as $value){
    $modules[] = $value;
}

return $modules;
