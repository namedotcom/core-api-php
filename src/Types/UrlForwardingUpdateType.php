<?php

namespace Namecom\Types;

enum UrlForwardingUpdateType: string
{
    case Masked = "masked";
    case Redirect = "redirect";
    case ThreeHundredTwo = "302";
}
