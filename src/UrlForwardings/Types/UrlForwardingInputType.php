<?php

namespace Namecom\UrlForwardings\Types;

enum UrlForwardingInputType: string
{
    case Masked = "masked";
    case Redirect = "redirect";
    case ThreeHundredTwo = "302";
}
