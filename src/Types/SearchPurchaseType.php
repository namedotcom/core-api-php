<?php

namespace Namecom\Types;

enum SearchPurchaseType: string
{
    case Registration = "registration";
    case AftermarketI = "aftermarket_i";
    case Expiring = "expiring";
    case Backorder = "backorder";
    case AftermarketS = "aftermarket_s";
    case AftermarketB = "aftermarket_b";
}
