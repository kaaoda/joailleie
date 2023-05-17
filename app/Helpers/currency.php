<?php

use App\Models\Currency;

function mainCurrency()
{
    return Currency::where("main", TRUE)->first();
}