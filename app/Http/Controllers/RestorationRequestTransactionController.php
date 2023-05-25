<?php

namespace App\Http\Controllers;

use App\Models\RestorationRequestTransaction;
use App\Http\Requests\StoreRestorationRequestTransactionRequest;
use App\Http\Requests\UpdateRestorationRequestTransactionRequest;

class RestorationRequestTransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestorationRequestTransactionRequest $request)
    {
        $safe = $request->safe()->toArray();
        return RestorationRequestTransaction::storeModel($safe, "Transactions created", back: TRUE);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestorationRequestTransactionRequest $request, RestorationRequestTransaction $restorationRequestTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestorationRequestTransaction $restorationRequestTransaction)
    {
        //
    }
}
