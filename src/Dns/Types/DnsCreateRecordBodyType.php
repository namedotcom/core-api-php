<?php

namespace Namecom\Dns\Types;

enum DnsCreateRecordBodyType: string
{
    case A = "A";
    case Aaaa = "AAAA";
    case Aname = "ANAME";
    case Cname = "CNAME";
    case Mx = "MX";
    case Ns = "NS";
    case Srv = "SRV";
    case Txt = "TXT";
}
