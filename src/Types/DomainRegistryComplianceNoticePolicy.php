<?php

namespace Namecom\Types;

enum DomainRegistryComplianceNoticePolicy: string
{
    case NewResolvesWithin100Days = "new_resolves_within_100_days";
    case NewUsedForAction = "new_used_for_action";
    case NewAccountForReview = "new_account_for_review";
}
