<?php

namespace Namecom\Types;

enum AvailableWebhooks: string
{
    case AccountCreditBalanceChange = "account.credit.balance_change";
    case AccountDomainRemoval = "account.domain.removal";
    case DomainLockStatusChange = "domain.lock.status_change";
    case DomainTransferStatusChange = "domain.transfer.status_change";
    case DomainTransferOutStatusChange = "domain.transfer_out.status_change";
    case ContactVerificationStatusChange = "contact.verification.status_change";
    case DomainTransferInternalIn = "domain.transfer.internal_in";
    case DomainTransferInternalOut = "domain.transfer.internal_out";
    case DomainRegistryRejection = "domain.registry.rejection";
    case DomainExpiration = "domain.expiration";
}
