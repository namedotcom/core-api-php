<?php

namespace Namecom\Types;

enum UrlForwardingType: string
{
    case Masked = "masked";
    case Redirect = "redirect";
    case ThreeHundredTwo = "302";
}
