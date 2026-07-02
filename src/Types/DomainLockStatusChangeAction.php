<?php

namespace Namecom\Types;

enum DomainLockStatusChangeAction: string
{
    case Added = "added";
    case Removed = "removed";
}
