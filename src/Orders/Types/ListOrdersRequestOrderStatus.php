<?php

namespace Namecom\Orders\Types;

enum ListOrdersRequestOrderStatus: string
{
    case Success = "success";
    case Failed = "failed";
    case Initialized = "initialized";
    case Review = "review";
    case Started = "started";
}
