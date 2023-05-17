<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait Storable
{
    private static function model(): Model
    {
        return new(get_class());
    }

    public static function storeModel(array $data, string $okMsg, string $redirectRoute = NULL, array $routeParams = NULL, $back = FALSE)
    {
        $model = self::model();
        if ($model->create($data))
            return $back === FALSE ? redirect()->route($redirectRoute, $routeParams)->with("success", $okMsg) : back()->with("success", $okMsg);
        else
            return back()->withErrors([
                "error" => "Something wrong happen"
            ]);
    }
}
