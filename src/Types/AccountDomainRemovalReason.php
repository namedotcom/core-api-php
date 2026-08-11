<?php

namespace Namecom\Types;

enum AccountDomainRemovalReason: string
{
    case Expiration = "expiration";
    case AgpRefund = "agp_refund";
    case Administrative = "administrative";
}
