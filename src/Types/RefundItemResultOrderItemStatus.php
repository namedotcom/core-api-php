<?php

namespace Namecom\Types;

enum RefundItemResultOrderItemStatus: string
{
    case Refunded = "refunded";
    case Failed = "failed";
    case Initialized = "initialized";
    case Canceled = "canceled";
}
