<?php

namespace Namecom\Types;

enum TransferStatus: string
{
    case Canceled = "canceled";
    case CanceledPendingRefund = "canceled_pending_refund";
    case Completed = "completed";
    case Failed = "failed";
    case Pending = "pending";
    case PendingInsert = "pending_insert";
    case PendingNewAuthCode = "pending_new_auth_code";
    case PendingRegistryUnlock = "pending_registry_unlock";
    case PendingTransfer = "pending_transfer";
    case PendingUnlock = "pending_unlock";
    case Rejected = "rejected";
    case SubmittingTransfer = "submitting_transfer";
}
