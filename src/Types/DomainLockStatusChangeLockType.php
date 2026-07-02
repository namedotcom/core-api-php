<?php

namespace Namecom\Types;

enum DomainLockStatusChangeLockType: string
{
    case RegistrarLock = "RegistrarLock";
    case TransferLock = "TransferLock";
    case AccountLock = "AccountLock";
    case ClientHold = "ClientHold";
    case VerificationClientHold = "VerificationClientHold";
    case VerificationHold = "VerificationHold";
    case PrivacyLock = "PrivacyLock";
    case ExpirationClientHold = "ExpirationClientHold";
}
