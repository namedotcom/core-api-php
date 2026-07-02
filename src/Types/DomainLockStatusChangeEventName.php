<?php

namespace Namecom\Types;

enum DomainLockStatusChangeEventName: string
{
    case DomainLockStatusChange = "domain.lock.status_change";
}
