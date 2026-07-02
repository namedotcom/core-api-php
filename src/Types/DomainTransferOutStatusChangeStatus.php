<?php

namespace Namecom\Types;

enum DomainTransferOutStatusChangeStatus: string
{
    case Initiated = "initiated";
    case Completed = "completed";
    case Canceled = "canceled";
}
