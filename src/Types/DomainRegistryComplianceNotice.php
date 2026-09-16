<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Payload sent when a registry reports that a domain must remediate a policy compliance issue before a deadline. By default, name.com emails the registrant; subscribing replaces that email so you can notify the end user from these fields. If you have signed an addendum to assume all email responsibility, name.com does not send the email and this webhook is the only delivery path. Whitelabeled branding is applied to the email when your account has it configured.
 */
class DomainRegistryComplianceNotice extends JsonSerializableType
{
    /**
     * @var value-of<DomainRegistryComplianceNoticeEventName> $eventName The name of the subscription event.
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName The domain subject to the registry compliance notice.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var value-of<DomainRegistryComplianceNoticePolicy> $policy Stable, namespaced identifier for the registry policy requiring remediation. Branch on this value rather than any human-readable field.
     */
    #[JsonProperty('policy')]
    public string $policy;

    /**
     * @var string $policyName Human-readable name of the registration policy associated with the compliance requirement.
     */
    #[JsonProperty('policyName')]
    public string $policyName;

    /**
     * @var string $policyUrl URL of the registration policy associated with the compliance requirement.
     */
    #[JsonProperty('policyUrl')]
    public string $policyUrl;

    /**
     * @var string $registryName Human-readable name of the registry that issued the compliance notice.
     */
    #[JsonProperty('registryName')]
    public string $registryName;

    /**
     * @var ?string $registryEmail Registry mailbox for evidence and questions, when the registry publishes one. Include it in the message body when notifying the registrant. Omitted when the registry does not publish a contact address.
     */
    #[JsonProperty('registryEmail')]
    public ?string $registryEmail;

    /**
     * @var ?string $originalMessageId RFC 5322 Message-ID of the registry's original notice, when available. Omitted when the registry notice had no Message-ID.
     */
    #[JsonProperty('originalMessageId')]
    public ?string $originalMessageId;

    /**
     * @var string $issueDescription Human-readable explanation of the compliance issue identified by the registry. Suitable for forwarding to the registrant. The wording may change; do not branch on this text.
     */
    #[JsonProperty('issueDescription')]
    public string $issueDescription;

    /**
     * @var string $remediationInstructions Human-readable instructions for resolving the compliance issue. Suitable for forwarding to the registrant. The wording may change; do not branch on this text.
     */
    #[JsonProperty('remediationInstructions')]
    public string $remediationInstructions;

    /**
     * @var string $agreementReminder Human-readable reminder that the registrant agreed to the applicable registration policy. Suitable for forwarding to the registrant. The wording may change; do not branch on this text.
     */
    #[JsonProperty('agreementReminder')]
    public string $agreementReminder;

    /**
     * @var string $noncomplianceConsequences Human-readable explanation of what the registry may do if the issue is not remediated by `complianceDeadline`. Suitable for forwarding to the registrant.
     */
    #[JsonProperty('noncomplianceConsequences')]
    public string $noncomplianceConsequences;

    /**
     * @var string $contactInstructions Human-readable instruction for the registrant to contact the registry (not the registrar) if they believe the domain is compliant or need to submit evidence. Suitable for forwarding.
     */
    #[JsonProperty('contactInstructions')]
    public string $contactInstructions;

    /**
     * @var DateTime $complianceDeadline The deadline by which the compliance issue must be remediated.
     */
    #[JsonProperty('complianceDeadline'), Date(Date::TYPE_DATETIME)]
    public DateTime $complianceDeadline;

    /**
     * @var int $remediationPeriodDays The remediation period supplied by the registry, in days.
     */
    #[JsonProperty('remediationPeriodDays')]
    public int $remediationPeriodDays;

    /**
     * @param array{
     *   eventName: value-of<DomainRegistryComplianceNoticeEventName>,
     *   domainName: string,
     *   policy: value-of<DomainRegistryComplianceNoticePolicy>,
     *   policyName: string,
     *   policyUrl: string,
     *   registryName: string,
     *   issueDescription: string,
     *   remediationInstructions: string,
     *   agreementReminder: string,
     *   noncomplianceConsequences: string,
     *   contactInstructions: string,
     *   complianceDeadline: DateTime,
     *   remediationPeriodDays: int,
     *   registryEmail?: ?string,
     *   originalMessageId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domainName = $values['domainName'];
        $this->policy = $values['policy'];
        $this->policyName = $values['policyName'];
        $this->policyUrl = $values['policyUrl'];
        $this->registryName = $values['registryName'];
        $this->registryEmail = $values['registryEmail'] ?? null;
        $this->originalMessageId = $values['originalMessageId'] ?? null;
        $this->issueDescription = $values['issueDescription'];
        $this->remediationInstructions = $values['remediationInstructions'];
        $this->agreementReminder = $values['agreementReminder'];
        $this->noncomplianceConsequences = $values['noncomplianceConsequences'];
        $this->contactInstructions = $values['contactInstructions'];
        $this->complianceDeadline = $values['complianceDeadline'];
        $this->remediationPeriodDays = $values['remediationPeriodDays'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
