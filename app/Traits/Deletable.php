<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

trait Deletable
{
    public static function deleteModel(Model $model)
    {
        $name = Str::afterLast(get_class($model), '\\');
        try {
            $model->deleteOrFail();
            return response(["success" => $name . " deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
