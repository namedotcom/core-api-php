<?php

namespace Namecom\Types;

enum UrlForwardingInputType: string
{
    case Masked = "masked";
    case Redirect = "redirect";
    case ThreeHundredTwo = "302";
}
