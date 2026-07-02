<?php

namespace Namecom\Types;

enum ResellerTldInfoClaimsCheckRequiredItem: string
{
    case Registration = "registration";
    case LandrushEap = "landrush_eap";
    case LandrushAuctionA = "landrush_auction_a";
    case LandrushReserveA = "landrush_reserve_a";
}
