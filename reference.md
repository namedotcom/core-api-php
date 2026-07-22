# Reference
<details><summary><code>$client-&gt;hello() -> ?HelloResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns basic information about the API server (useful for testing connectivity and version checks).
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->hello();
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Account Info
<details><summary><code>$client-&gt;accountInfo-&gt;checkAccountBalance() -> ?CheckAccountBalanceResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns the current account credit balance for the authenticated user.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->accountInfo->checkAccountBalance();
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Accounts
<details><summary><code>$client-&gt;accounts-&gt;createAccount($request) -> ?CreateAccountResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Creates a new sub-account under your authenticated reseller account and returns API credentials for the new account.  This endpoint is only available to approved reseller accounts. Contact name.com support to request access.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->accounts->createAccount(
    new CreateAccountRequest([
        'account' => new AccountRequest([
            'contacts' => new ContactsRequest([
                'registrant' => new RegistrantContactRequest([
                    'firstName' => 'Jane',
                    'lastName' => 'Doe',
                    'address1' => '123 Main St.',
                    'city' => 'Denver',
                    'state' => 'CO',
                    'zip' => '12345',
                    'country' => 'US',
                    'email' => 'admin@example.net',
                    'phone' => '+13035551212',
                ]),
            ]),
            'accountName' => 'reseller_subaccount',
            'password' => 'SecureP4ss!',
        ]),
        'apiTos' => true,
        'tos' => true,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$account:** `AccountRequest` — The account details for the new account being created.
    
</dd>
</dl>

<dl>
<dd>

**$apiTos:** `bool` — Must be set to true to indicate acceptance of the API Terms of Service.
    
</dd>
</dl>

<dl>
<dd>

**$tos:** `bool` — Must be set to true to indicate acceptance of the general Terms of Service.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Domains
<details><summary><code>$client-&gt;domains-&gt;listDomains($request) -> ?ListDomainsResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Lists all domains in your account (basic details for each domain).
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->listDomains(
    new ListDomainsRequest([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$perPage:** `?int` — Per Page is the number of records to return per request. Per Page defaults to 250.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return.
    
</dd>
</dl>

<dl>
<dd>

**$sort:** `?string` — Sort specifies which domain property to order by.
    
</dd>
</dl>

<dl>
<dd>

**$dir:** `?string` — Dir indicates direction of sort. Possible values are 'asc' (default) or 'desc'.
    
</dd>
</dl>

<dl>
<dd>

**$domainName:** `?string` — DomainName filters domains by exact domain name or wildcard (starts with '*').
    
</dd>
</dl>

<dl>
<dd>

**$tld:** `?string` — Tld filters on specific tld.
    
</dd>
</dl>

<dl>
<dd>

**$locked:** `?bool` — Locked filters on locked domains.
    
</dd>
</dl>

<dl>
<dd>

**$createDate:** `?string` — CreateDate filters domains created on this date.
    
</dd>
</dl>

<dl>
<dd>

**$createDateStart:** `?string` — CreateDateStart filters domains created on or after this date.
    
</dd>
</dl>

<dl>
<dd>

**$createDateEnd:** `?string` — CreateDateEnd filters domains created on or before this date.
    
</dd>
</dl>

<dl>
<dd>

**$expireDate:** `?string` — ExpireDate filters domains expiring on this date.
    
</dd>
</dl>

<dl>
<dd>

**$expireDateStart:** `?string` — ExpireDateStart filters domains with expire date on or after this date.
    
</dd>
</dl>

<dl>
<dd>

**$expireDateEnd:** `?string` — ExpireDateEnd filters domains with expire date on or before this date.
    
</dd>
</dl>

<dl>
<dd>

**$privacyEnabled:** `?bool` — PrivacyEnabled indicates whether there is a privacy product associated with the domain.
    
</dd>
</dl>

<dl>
<dd>

**$isPremium:** `?bool` — IsPremium indicates whether the domain is a premium domain.
    
</dd>
</dl>

<dl>
<dd>

**$autorenewEnabled:** `?bool` — AutorenewEnabled indicates if the domain will attempt to renew automatically before expiration.
    
</dd>
</dl>

<dl>
<dd>

**$orderId:** `?int` — OrderId specifies the order number of a domain purchase.
    
</dd>
</dl>

<dl>
<dd>

**$includeRenewalPrice:** `?bool` — IncludeRenewalPrice indicates whether to include renewal pricing information in the response.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;createDomain($request) -> ?CreateDomainResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Registers a new domain under your account. You must provide `domain.domainName` at minimum.
This endpoint is commonly used to programmatically onboard new domains through user signup flows or checkout experiences.

If no contacts are passed in this request, the default contacts for your name.com account will be used.

### Create Domain pricing

See the [Domain purchase pricing guide](/guides/domain-pricing) for the full reference.
**Recommendation:** For most integrations, scope discovery to `purchaseType: registration`. Other purchase types are supported but add complexity — details in the guide above.

**Discovery (required before create):** Call [Search](/api/v1/reference/domains/search) or [Check Availability](/api/v1/reference/domains/check-availability), not Get Pricing alone. Both return the same `SearchResult` fields (`purchaseType`, `purchasePrice`, `premium`, `purchasable`). [Zone Check](/api/v1/reference/domains/zone-check) is designed for rapid availability checks only; it is not sufficient to complete a purchase.

### Getting the price for Create Domain

1. **Search or Check Availability** → copy `purchaseType`, `premium`, note `purchasePrice`.

2. Branch on `purchaseType`:
   - **`registration` + `premium: false`** — omit `purchasePrice` on create, set `years`. Optional: Get Pricing with same `years` to preview the total.
   - **`registration` + `premium: true`** — Get Pricing with same `years` → pass `purchasePrice` exactly.
   - **aftermarket / expiring / backorder** — use discovery `purchasePrice` (flat fee). Re-check discovery before create. Do not use Get Pricing for create price. `years` does not multiply price or guarantee registration length.

3. If `purchasePrice` is sent, it must match exactly or the request fails with `400` and `"Purchase price does not match"`.

**Years on acquisition types:** For `aftermarket_s`, `aftermarket_b`, `aftermarket_i`, `expiring`, and `backorder`: omit `years` or pass the TLD default. Check `domain.expireDate` in the response; [Renew](/api/v1/reference/domains/renew-domain) to extend registration.

### Best Practices For Domain Creates

In general, you should check that a domain is available prior to attempting to purchase a domain.
You can use either the [checkAvailability](/api/v1/reference/domains/check-availability) endpoint, or the [Search](/api/v1/reference/domains/search) endpoint
to confirm that a domain is purchasable.

#### Important Note on Dropcatching and Abuse Prevention

_The createDomain endpoint is designed for standard domain registrations and is not intended for automated dropcatching (i.e., mass or high-frequency attempts to register domains the moment they become available after expiration). The use of drop-catching tools or services to acquire expired domains is strictly prohibited. All domain acquisitions must go through approved channels to ensure fair and transparent access._

#### Contact Verification
When a new domain registration is created and a contact is submitted, name.com may need to validate the contact's email address in accordance with ICANN policy. This validation involves sending an email to the provided address, prompting the recipient to click a link to verify their email address.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->createDomain(
    new CreateDomainRequest([
        'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
        'domain' => new DomainCreatePayload([
            'domainName' => 'example.com',
        ]),
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$idempotencyKey:** `?string` — A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result.
    
</dd>
</dl>

<dl>
<dd>

**$domain:** `DomainCreatePayload` 
    
</dd>
</dl>

<dl>
<dd>

**$purchasePrice:** `?float` — PurchasePrice is the price in USD for purchasing this domain for the minimum time period (typically 1 year). PurchasePrice is required if purchaseType is not "registration" or if it is a premium domain. If privacyEnabled is set, the regular price for Whois Privacy protection will be added automatically. If VAT tax applies, it will also be added automatically.
    
</dd>
</dl>

<dl>
<dd>

**$purchaseType:** `?string` — PurchaseType indicates what kind of purchase this domain create is for. Defaults to `registration` if omitted. **Recommended:** Use `registration` unless you support acquisition types (aftermarket, expiring, backorder) — see the [Domain purchase pricing guide](/guides/domain-pricing). This value should be copied from the [Search](/api/v1/reference/domains/search) or [Check Availability](/api/v1/reference/domains/check-availability) result. The value `registration` covers both standard and **registry premium** domains — use the `premium` flag from the discovery result to tell them apart. Aftermarket, expiring, and backorder types use flat acquisition fees from Search or Check Availability; see the [Domain pricing guide](/guides/domain-pricing).
    
</dd>
</dl>

<dl>
<dd>

**$tldRequirements:** `?array` 

TLDRequirements is a way to pass additional data that is required by some registries. You can check before registration by using the [Domain Info](/api/v1/reference/domain-info/get-specific-tld-requirements) API.
As these requirements vary wildly between registries and TLDs, we are not attempting to document them here.
#### IDN Domains
This parameter is required for registering domains that contain non-ASCII characters.  The value should be the specific code for the character set, such as `ES` for Spanish, or `CYRL` for Cyrillic. These abbreviations can vary between TLDs, and it is highly recommended that you use [Domain Info](/api/v1/reference/domain-info/get-specific-tld-requirements) API to ensure that the TLD allows for the specific IDN table, as well as the correct abbreviation.
    
</dd>
</dl>

<dl>
<dd>

**$claims:** `?DomainClaimsInfo` 
    
</dd>
</dl>

<dl>
<dd>

**$years:** `?int` — Years specifies the registration term in years. **Only affects price and registration length for `purchaseType: registration`.** Defaults to each TLD's minimum if omitted (usually 1; 2 for `.ai`). Must be a supported registration term for the TLD when `purchaseType` is `registration` (commonly 1–10 years). For `purchaseType: registration` when `purchasePrice` is required, call [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with the same `years` value. For aftermarket, expiring, and backorder types: pass the TLD default — it does **not** multiply `purchasePrice` and does **not** guarantee a multi-year registration. Check `domain.expireDate` in the create response for actual expiry. To add registration time after acquisition, use [Renew Domain](/api/v1/reference/domains/renew-domain).
    
</dd>
</dl>

<dl>
<dd>

**$promoCode:** `?string` — PromoCode is an optional promotional code to apply to the domain purchase. Only one promo code can be applied per request.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;getDomain($domainName) -> ?DomainResponsePayload</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves detailed information for a specific domain in your account.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->getDomain(
    'example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to retrieve.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;updateDomain($domainName, $request) -> ?DomainResponsePayload</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Allows updating of the autorenew, WhoIs Privacy and lock status of the specified domain. The request requires one, or any combination of the parameters in order to pass validation. If any of the requested updates failed, the domain will be returned to it's original state.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->updateDomain(
    'domainName',
    new UpdateDomainRequest([
        'body' => new UpdateDomainRequestBodyAutorenewEnabled([
            'autorenewEnabled' => true,
        ]),
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to update.
    
</dd>
</dl>

<dl>
<dd>

**$request:** `UpdateDomainRequestBodyAutorenewEnabled|UpdateDomainRequestBodyPrivacyEnabled|UpdateDomainRequestBodyLocked` 
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;disableAutorenew($domainName) -> ?Domain</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Turns off automatic renewal for a domain.  **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->disableAutorenew(
    'example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to disable autorenew for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;disableWhoisPrivacy($domainName) -> ?Domain</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Disables WHOIS privacy protection on a domain. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->disableWhoisPrivacy(
    'example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to disable whoisprivacy for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;enableAutorenew($domainName) -> ?Domain</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Turns on automatic renewal for a domain. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->enableAutorenew(
    'example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to enable autorenew for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;enableWhoisPrivacy($domainName) -> ?Domain</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Enables WHOIS privacy protection on a domain. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->enableWhoisPrivacy(
    'domainName',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to enable whoisprivacy for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;getAuthCodeForDomain($domainName) -> ?AuthCodeResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves the transfer authorization code (EPP code) for a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->getAuthCodeForDomain(
    'domainName',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to retrieve the authorization code for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;getPricingForDomain($domainName, $request) -> ?PricingResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns registration, renewal, and transfer pricing for a domain and term.

**Not a discovery endpoint:** Does not return `purchaseType`. Cannot determine whether a domain is acquired via registration vs aftermarket/expiring/backorder — call [Search](/api/v1/reference/domains/search) or [Check Availability](/api/v1/reference/domains/check-availability) first.

**Scope:** `purchasePrice` and `premium` reflect **standard and registry-premium registration** only. They do **not** return aftermarket, expiring, or backorder acquisition prices. For those types, use `purchasePrice` from Search or Check Availability.

**Registration create (`purchaseType: registration`):** When create requires `purchasePrice` (registry premium), call with the **same** `years` you will send on create. Pass `purchasePrice` directly — it is the **total** for that term, not a per-year component.

**Renew:** Pass `renewalPrice` as `purchasePrice` on [Renew Domain](/api/v1/reference/domains/renew-domain) for premium renewals — not for computing Create Domain totals.

**Transfer:** Pass `transferPrice` as `purchasePrice` on [Create Transfer](/api/v1/reference/transfers/create-transfer) for premium transfers. The `years` query parameter does not affect `transferPrice`.

See the [Domain pricing guide](/guides/domain-pricing) for the full workflow.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->getPricingForDomain(
    'domainName',
    new GetPricingForDomainRequest([
        'years' => 2,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to retrieve.
    
</dd>
</dl>

<dl>
<dd>

**$years:** `?int` — Years specifies the registration term to price in years. Defaults to each TLD's minimum registration term if omitted — usually 1 year (2 for `.ai`). Must be a supported registration term for the TLD (commonly 1–10 years). Use the same value on Create Domain when passing `purchasePrice` for `purchaseType: registration`.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;lockDomain($domainName) -> ?Domain</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Locks a domain to prevent it from being transferred. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->lockDomain(
    'example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to lock.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;purchasePrivacy($domainName, $request) -> ?PrivacyResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Adds or renews WHOIS privacy protection for a domain. This is used to ensure personal contact details remain hidden from public WHOIS lookups.  If WHOIS privacy is already enabled, this will extend the protection. If it’s not yet active, this will both purchase and enable the service.  This is a billable action unless covered by a bundled privacy plan.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->purchasePrivacy(
    'domainName',
    new DomainsPurchasePrivacyBody([
        'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to purchase Whois Privacy for.
    
</dd>
</dl>

<dl>
<dd>

**$idempotencyKey:** `?string` — A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result.
    
</dd>
</dl>

<dl>
<dd>

**$purchasePrice:** `?float` — PurchasePrice is the (prorated) amount you expect to pay.
    
</dd>
</dl>

<dl>
<dd>

**$years:** `?int` — Years is the number of years you wish to purchase Whois Privacy for. Years defaults to 1 and cannot be more then the domain expiration date.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;renewDomain($domainName, $request) -> ?RenewDomainResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Renews an existing domain for an additional registration period. Include the domain name and renewal term. Omit `purchasePrice` for standard (non-premium) renewals. For premium renewals, pass `renewalPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with matching `years` as `purchasePrice`. Renewal pricing is separate from Create Domain registration/acquisition pricing. This is typically used to extend ownership before a domain’s expiration.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->renewDomain(
    'domainName',
    new DomainsRenewDomainBody([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to renew.
    
</dd>
</dl>

<dl>
<dd>

**$purchasePrice:** `?float` — PurchasePrice is the total USD renewal cost for the requested `years`, before VAT. VAT is applied when applicable and must not be included here. If sent, must match Get Pricing `renewalPrice` exactly. **Omit** for standard (non-premium) renewals. **Required** for premium renewals — use `renewalPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with matching `years`.
    
</dd>
</dl>

<dl>
<dd>

**$years:** `?int` — Years specifies the renewal term in years. Defaults to each TLD's minimum registration term if omitted — usually 1 year (2 for `.ai`). Must be a supported registration term for the TLD (commonly 1–10 years). For premium renewals, call [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with the same `years` value.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;setContacts($domainName, $request) -> ?DomainResponsePayload</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Updates WHOIS contact information for a domain. This includes the registrant, administrative, technical, and billing contacts.  All contact objects must be complete — partial updates are not supported.  You should fetch the existing contact data first (e.g., via [GetDomain](/api/v1/reference/domains/get-domain) and modify only the values you wish to change.  This call replaces all four contact sets at once.
#### Contact Verification
When registrant contact information is updated, validation may be triggered if the new contact information has not been previously validated. This validation is required by ICANN for all TLDs except country-code TLDs (ccTLDs). This validation involves sending an email to the provided address, prompting the recipient to click a link to verify their email address.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->setContacts(
    'example.com',
    new DomainsSetContactsBody([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to set the contacts for.
    
</dd>
</dl>

<dl>
<dd>

**$contacts:** `?ContactsRequest` 
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;setNameservers($domainName, $request) -> ?DomainResponsePayload</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

SetNameservers will set the nameservers for the Domain. This operation updates the DNS configuration by changing which nameservers are responsible for the domain's zone.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->setNameservers(
    'example.com',
    new DomainsSetNameserversBody([
        'nameservers' => [
            'ns1.name.com',
            'ns2.name.com',
        ],
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to set the nameservers for.
    
</dd>
</dl>

<dl>
<dd>

**$nameservers:** `array` — Nameservers is a list of the nameservers to set. Nameservers should already be set up and hosting the zone properly as some registries will verify before allowing the change.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;unlockDomain($domainName) -> ?Domain</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Unlocks a domain to allow it to be transferred. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->unlockDomain(
    'domainName',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to unlock.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;checkAvailability($request) -> ?SearchResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Checks whether up to 50 domain names are purchasable and returns **discovery** pricing for each result.

**Discovery endpoint:** Returns `SearchResult` fields — `purchaseType`, `purchasePrice`, `premium`, `purchasable`. [Search](/api/v1/reference/domains/search) returns the same fields for keyword/suggestion flows. Use this endpoint to determine what to send on [Create Domain](/api/v1/reference/domains/create-domain).

When results show `premium: true` or a non-`registration` `purchaseType`, follow the [Domain pricing guide](/guides/domain-pricing) before calling Create Domain. For non-registration types, re-check Check Availability immediately before create — acquisition prices can change.

**Recommendation:** Set `purchaseType` to `registration`. Most resellers 
restrict results to domains with a `purchaseType` of `registration`
to ensure predictable pricing and immediate fulfillment. Other purchase types
(such as aftermarket variants) can introduce higher costs and non-instant
transactions that may be delayed or declined by third parties.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->checkAvailability(
    new AvailabilityRequest([
        'domainNames' => [
            'domainNames',
        ],
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainNames:** `array` — DomainNames is the list of domains to check if they are available.
    
</dd>
</dl>

<dl>
<dd>

**$purchaseType:** `?string` — Optional filter. **Recommended:** `registration` for most integrations — omit only if you support acquisition types. Non-matching domains are returned with `purchasable: false` (Search omits them instead). See the [Domain purchase pricing guide](/guides/domain-pricing).
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;search($request) -> ?SearchResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Searches for domain name suggestions based on a keyword or term. Important: Do not
encode the `:` in the path. Use `/core/v1/domains:search`, not `/core/v1/domains%3Asearch`.

**Discovery endpoint:** Returns `SearchResult` fields — `purchaseType`, `purchasePrice`, `premium`, `purchasable`.

**Recommendation:** Set `purchaseType` to `registration`. Most resellers restrict
results to domains with a `purchaseType` of `registration` to ensure predictable
pricing and immediate fulfillment. Other purchase types (such as aftermarket) can
introduce higher costs and non-instant transactions that may be delayed or declined
by third parties.
With `purchaseType: registration`, domains that do not match the filter are **omitted** from results (unlike Check Availability, which returns them with `purchasable: false`).

When results show `premium: true` or a non-`registration` `purchaseType`, follow the [Domain pricing guide](/guides/domain-pricing) before calling Create Domain. For all types, re-check with Check Availability immediately before create — prices and availability can change.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->search(
    new SearchRequest([
        'keyword' => 'mydomain',
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$keyword:** `string` — Keyword is the search term to search for. It can be just a word, or a whole domain name.
    
</dd>
</dl>

<dl>
<dd>

**$timeout:** `?int` 

Timeout is a value in milliseconds on how long to perform the search for. Valid timeouts are between 500ms to 12,000ms. If not specified, timeout defaults to 12,000ms.
Since some additional processing is performed on the results, a response may take longer then the timeout.
    
</dd>
</dl>

<dl>
<dd>

**$tldFilter:** `?array` — TLDFilter will limit results to only contain the specified TLDs. There is a maximum of 50 TLDs that can be used in this filter
    
</dd>
</dl>

<dl>
<dd>

**$purchaseType:** `?string` — Optional. Limits results to the given `purchaseType`. **Recommended:** `registration` for most integrations — omit only if you choose to support acquisition types. See the [Domain purchase pricing guide](/guides/domain-pricing).
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domains-&gt;zoneCheck($request) -> ?ZoneCheckResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Zone Check offers a rapid, preliminary check for domain availability by leveraging cached zone file data.  Ideal for large-batch queries, it provides a high confidence indication of a domain's availability significantly faster than live registry checks.  For definitive, real-time availability and pricing, you can follow up with the standard [Check Availability](/api/v1/reference/domains/check-availability) call.
The API normalizes and validates each submitted domain string. Domains that fail validation, use an unsupported TLD for this service, or  are otherwise not eligible for zone check are **removed** from the request before the zone file lookup runs. The response includes **only**  a numeric count of removed domains (`removed`); individual removed strings are not returned. A future API version may extend the contract to  include details about removed domains.

For the best results and to avoid `400 Bad Request` errors after cleaning, ensure each domain string meets the criteria described for  `domainNames` in the request body schema.

If no valid domains remain after this process, the API returns a `400 Bad Request` response.
**Note:** The cached zone files used for this check are refreshed twice daily based on the latest available data from the registries.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domains->zoneCheck(
    new ZoneCheckRequest([
        'domainNames' => [
            'example.com',
            'example.net',
            'example.org',
        ],
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainNames:** `array` 

Array of domain names to check. Each entry is normalized and validated before zone check runs. Entries that are not valid domain strings,  that use unsupported TLDs for this service, or that fail other pre-validation rules are omitted from the check; the response `removed` field  reports how many were omitted (not which values).

**Valid domain string (after normalization)** — for reliable results and to avoid errors once all entries are removed:

- **Allowed characters:** ASCII letters (`a`–`z`), digits (`0`–`9`), and hyphens (`-`).

- **Hyphen rules:** A domain (the part between dots) must not start or end with a hyphen (for example, `-test.com` and `test-.com` are invalid).

- **Domain length:** Each domain must be between 1 and 63 characters.

- **Internationalized domains (IDNs):** Non-ASCII characters (for example `ö` or `ñ`) should be submitted as Punycode (`xn--...`) for  consistent registry resolution.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## DNSSECs
<details><summary><code>$client-&gt;dnsseCs-&gt;listDnsseCs($domainName) -> ?ListDnsseCsResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Lists all DNSSEC (DS) records configured for a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dnsseCs->listDnsseCs(
    'domainName',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to list keys for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;dnsseCs-&gt;createDnssec($domainName, $request) -> ?Dnssec</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Adds (registers) a new DNSSEC DS record for a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dnsseCs->createDnssec(
    'domainName',
    new CreateDnssecBody([
        'algorithm' => 1,
        'digest' => 'digest',
        'digestType' => 1,
        'keyTag' => 1,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name to create keys for.
    
</dd>
</dl>

<dl>
<dd>

**$algorithm:** `int` 
    
</dd>
</dl>

<dl>
<dd>

**$digest:** `string` — Digest is a digest of the DNSKEY RR that is registered with the registry.
    
</dd>
</dl>

<dl>
<dd>

**$digestType:** `int` 
    
</dd>
</dl>

<dl>
<dd>

**$keyTag:** `int` 
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;dnsseCs-&gt;getDnssec($domainName, $digest) -> ?Dnssec</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves details of a specific DNSSEC record for a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dnsseCs->getDnssec(
    'domainName',
    'digest',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name.
    
</dd>
</dl>

<dl>
<dd>

**$digest:** `string` — Digest is the digest for the DNSKEY RR to retrieve.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;dnsseCs-&gt;deleteDnssec($domainName, $digest)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Deletes a DNSSEC record from a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dnsseCs->deleteDnssec(
    'domainName',
    'digest',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain name the key is registered for.
    
</dd>
</dl>

<dl>
<dd>

**$digest:** `string` — Digest is the digest for the DNSKEY RR to remove from the registry.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Email Forwardings
<details><summary><code>$client-&gt;emailForwardings-&gt;listEmailForwardings($domainName, $request) -> ?ListEmailForwardingsResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns a paginated list of all email forwarding rules for a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->emailForwardings->listEmailForwardings(
    'domainName',
    new ListEmailForwardingsRequest([
        'perPage' => 100,
        'page' => 1,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to list email forwarded boxes for.
    
</dd>
</dl>

<dl>
<dd>

**$perPage:** `?int` — (optional) Per Page is the number of records to return per request. Per Page defaults to 500 if not set.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — (optional) Page is which page to return. Default to page 1 if not set.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;emailForwardings-&gt;createEmailForwarding($domainName, $request) -> ?EmailForwarding</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Creates a new email forwarding rule for a domain, such as redirecting info@example.com to an external inbox.  If this is the first email forwarding rule created for the domain, the API may also update your MX records automatically to enable mail routing.  The alias must not conflict with existing email services or MX records.  To modify a forwarding rule later, use [UpdateEmailForwarding](/api/v1/reference/email-forwardings/update-email-forwarding).
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->emailForwardings->createEmailForwarding(
    'example.com',
    new CreateEmailForwardingRequest([
        'emailBox' => 'admin',
        'emailTo' => 'webmaster@example.com',
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain part of the email address to forward.
    
</dd>
</dl>

<dl>
<dd>

**$emailBox:** `string` — EmailBox is the user portion of the email address to forward. If your email is "admin@example.com", it would just be "admin"
    
</dd>
</dl>

<dl>
<dd>

**$emailTo:** `string` — EmailTo is the entire email address to forward email to.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;emailForwardings-&gt;getEmailForwarding($domainName, $emailBox) -> ?EmailForwarding</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves the details of a specific email forwarding entry.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->emailForwardings->getEmailForwarding(
    'domainName',
    'emailBox',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to list email forwarded box for.
    
</dd>
</dl>

<dl>
<dd>

**$emailBox:** `string` — EmailBox is which email box to retrieve.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;emailForwardings-&gt;updateEmailForwarding($domainName, $emailBox, $request) -> ?EmailForwarding</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Updates the destination email address for an existing forwarding rule.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->emailForwardings->updateEmailForwarding(
    'domainName',
    'emailBox',
    new EmailForwardingsUpdateEmailForwardingBody([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain part of the email address to forward.
    
</dd>
</dl>

<dl>
<dd>

**$emailBox:** `string` — EmailBox is the user portion of the email address to forward.
    
</dd>
</dl>

<dl>
<dd>

**$emailTo:** `?string` — EmailTo is the entire email address to forward email to.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;emailForwardings-&gt;deleteEmailForwarding($domainName, $emailBox)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Deletes an email forwarding rule from a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->emailForwardings->deleteEmailForwarding(
    'domainName',
    'emailBox',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to delete the email forwarded box from.
    
</dd>
</dl>

<dl>
<dd>

**$emailBox:** `string` — EmailBox is which email box to delete.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## DNS
<details><summary><code>$client-&gt;dns-&gt;listRecords($domainName, $request) -> ?ListRecordsResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Lists all DNS records for a specified domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dns->listRecords(
    'domainName',
    new ListRecordsRequest([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the zone to list the records for.
    
</dd>
</dl>

<dl>
<dd>

**$perPage:** `?int` — Per Page is the number of records to return per request. Per Page defaults to 500.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;dns-&gt;createRecord($domainName, $request) -> ?Record</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Adds a new DNS record to the specified domain zone. Provide the record type (e.g. A, MX, CNAME), host, value, and TTL.  This is used for configuring domain-based services such as email, website hosting, or third-party verifications.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dns->createRecord(
    'domainName',
    new DnsCreateRecordBody([
        'answer' => 'answer',
        'host' => 'host',
        'type' => DnsCreateRecordBodyType::A->value,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the zone that the record belongs to.
    
</dd>
</dl>

<dl>
<dd>

**$answer:** `string` 

Answer is either the IP address for A or AAAA records; the target for ANAME, CNAME, MX, or NS records; the text for TXT records.
For SRV records, answer has the following format: "{weight} {port} {target}" e.g. "1 5061 sip.example.org".
    
</dd>
</dl>

<dl>
<dd>

**$fqdn:** `?string` — FQDN is the Fully Qualified Domain Name. It is the combination of the host and the domain name. It always ends in a ".". FQDN is ignored in CreateRecord, specify via the Host field instead.
    
</dd>
</dl>

<dl>
<dd>

**$host:** `string` 

Host is the hostname relative to the zone: e.g. for a record for blog.example.org, domain would be "example.org" and host would be "blog".
An apex record would be specified by either an empty host "" or "@".
A SRV record would be specified by "_{service}._{protocol}.{host}": e.g. "_sip._tcp.phone" for _sip._tcp.phone.example.org.
    
</dd>
</dl>

<dl>
<dd>

**$id:** `?int` — Unique record id. Value is ignored on Create, and must match the URI on Update.
    
</dd>
</dl>

<dl>
<dd>

**$priority:** `?int` — Priority is only required for MX and SRV records, it is ignored for all others.
    
</dd>
</dl>

<dl>
<dd>

**$ttl:** `?int` — TTL is the time this record can be cached for in seconds. name.com allows a minimum TTL of 300, or 5 minutes.
    
</dd>
</dl>

<dl>
<dd>

**$type:** `string` — Type is one of the following: A, AAAA, ANAME, CNAME, MX, NS, SRV, or TXT.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;dns-&gt;getRecord($domainName, $id) -> ?Record</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves details of a specific DNS record.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dns->getRecord(
    'domainName',
    1,
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the zone the record exists in.
    
</dd>
</dl>

<dl>
<dd>

**$id:** `int` — ID is the server-assigned unique identifier for this record.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;dns-&gt;updateRecord($domainName, $id, $request) -> ?Record</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Replaces an existing DNS record with new data. This is a full overwrite — all required fields (host, type, answer, ttl) must be included in the request body. If you omit a field, the existing value will not be preserved and the request may fail. Use [GetRecord](/api/v1/reference/dns/get-record) beforehand to retrieve the current values if you intend to modify just one field. The record ID must belong to a domain you manage.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dns->updateRecord(
    'domainName',
    1,
    new DnsUpdateRecordBody([
        'answer' => 'answer',
        'type' => DnsUpdateRecordBodyType::A->value,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the zone that the record belongs to.
    
</dd>
</dl>

<dl>
<dd>

**$id:** `int` — Unique record id. Value is ignored on Create, and must match the URI on Update.
    
</dd>
</dl>

<dl>
<dd>

**$answer:** `string` 

Answer is either the IP address for A or AAAA records; the target for ANAME, CNAME, MX, or NS records; the text for TXT records.
For SRV records, answer has the following format: "{weight} {port} {target}" e.g. "1 5061 sip.example.org".
    
</dd>
</dl>

<dl>
<dd>

**$fqdn:** `?string` — FQDN is the Fully Qualified Domain Name. It is the combination of the host and the domain name. It always ends in a ".". FQDN is ignored in CreateRecord, specify via the Host field instead.
    
</dd>
</dl>

<dl>
<dd>

**$host:** `?string` 

Host is the hostname relative to the zone: e.g. for a record for blog.example.org, domain would be "example.org" and host would be "blog".
An apex record would be specified by either an empty host "" or "@".
A SRV record would be specified by "_{service}._{protocol}.{host}": e.g. "_sip._tcp.phone" for _sip._tcp.phone.example.org.
    
</dd>
</dl>

<dl>
<dd>

**$priority:** `?int` — Priority is only required for MX and SRV records, it is ignored for all others.
    
</dd>
</dl>

<dl>
<dd>

**$ttl:** `?int` — TTL is the time this record can be cached for in seconds. name.com allows a minimum TTL of 300, or 5 minutes.
    
</dd>
</dl>

<dl>
<dd>

**$type:** `string` — Type is one of the following: A, AAAA, ANAME, CNAME, MX, NS, SRV, or TXT.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;dns-&gt;deleteRecord($domainName, $id)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Removes a DNS record by ID. Often used during cleanup operations or when replacing outdated DNS settings with updated records.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->dns->deleteRecord(
    'domainName',
    1,
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the zone that the record to be deleted exists in.
    
</dd>
</dl>

<dl>
<dd>

**$id:** `int` — ID is the server-assigned unique identifier for the Record to be deleted. If the Record with that ID does not exist in the specified Domain, an error is returned.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## URL Forwardings
<details><summary><code>$client-&gt;urlForwardings-&gt;listUrlForwardings($domainName, $request) -> ?ListUrlForwardingsResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns all URL forwarding settings configured for a domain. **Deprecated.** Use [List URL Forwardings by domain](/api/v1/reference/url-forwardings/list-urlforwardings-by-domain) instead, which returns entries with an `id` for use with by-ID endpoints.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->listUrlForwardings(
    'example.com',
    new ListUrlForwardingsRequest([
        'perPage' => 100,
        'page' => 1,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to list URL forwarding entries for.
    
</dd>
</dl>

<dl>
<dd>

**$perPage:** `?int` — Per Page is the number of records to return per request. Per Page defaults to 500.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return. Starts at 1 for first page.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;createUrlForwarding($domainName, $request) -> ?UrlForwardingResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Sets up a new URL forwarding (redirect) for a domain or subdomain. If this is the first URL forwarding entry, it may modify the A records for the domain accordingly. Note that changes may take up to 24 hours to fully propagate.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->createUrlForwarding(
    'example.com',
    new CreateUrlForwardingRequest([
        'body' => new UrlForwardingInput([
            'forwardsTo' => 'https://destination-site.com',
            'host' => 'www',
            'type' => UrlForwardingInputType::Masked->value,
        ]),
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain part of the hostname to forward.
    
</dd>
</dl>

<dl>
<dd>

**$request:** `UrlForwardingInput` 
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;getUrlForwarding($domainName, $host) -> ?UrlForwardingResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves the details of a specific URL forwarding configuration. **Deprecated.** Use [Get URL Forwarding by ID](/api/v1/reference/url-forwardings/get-urlforwarding-by-id) instead.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->getUrlForwarding(
    'example.com',
    'www.example.org',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to get the URL forwarding entry for.
    
</dd>
</dl>

<dl>
<dd>

**$host:** `string` — The full hostname, including subdomain.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;updateUrlForwarding($domainName, $host, $request) -> ?UrlForwardingResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Modifies an existing URL forwarding rule. Changes may take up to 24 hours to fully propagate. **Deprecated.** Use [Update URL Forwarding by ID](/api/v1/reference/url-forwardings/update-urlforwarding-by-id) instead.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->updateUrlForwarding(
    'example.com',
    'www.example.org',
    new UpdateUrlForwardingRequest([
        'body' => new UrlForwardingInput([
            'forwardsTo' => 'https://destination-site.com',
            'host' => 'www',
            'type' => UrlForwardingInputType::Masked->value,
        ]),
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain part of the hostname to forward.
    
</dd>
</dl>

<dl>
<dd>

**$host:** `string` — The full hostname, including subdomain.
    
</dd>
</dl>

<dl>
<dd>

**$request:** `UrlForwardingInput` 
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;deleteUrlForwarding($domainName, $host)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Removes a URL forwarding configuration from the domain. This operation cannot be undone. **Deprecated.** Use [Delete URL Forwarding by ID](/api/v1/reference/url-forwardings/delete-urlforwarding-by-id) instead.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->deleteUrlForwarding(
    'example.com',
    'www.example.org',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to delete the URL forwarding entry from.
    
</dd>
</dl>

<dl>
<dd>

**$host:** `string` — The full hostname, including subdomain.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;listUrlForwardingsByDomain($domainName, $request) -> ?ListUrlForwardingsResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns all URL forwarding settings configured for a domain. Each entry includes an `id` that can be used with the URL Forwarding by-ID endpoints to get, update, or delete records.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->listUrlForwardingsByDomain(
    'example.com',
    new ListUrlForwardingsByDomainRequest([
        'perPage' => 100,
        'page' => 1,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to list URL forwarding entries for. The domain must be owned by the authenticated account.
    
</dd>
</dl>

<dl>
<dd>

**$perPage:** `?int` — Per Page is the number of records to return per request. Per Page defaults to 500.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return. Starts at 1 for first page.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;getUrlForwardingById($domainName, $id) -> ?UrlForwardingResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves the details of a specific URL forwarding configuration by ID.  The domain must be owned by the authenticated account.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->getUrlForwardingById(
    'example.com',
    12345,
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain that owns the URL forwarding entry. Must be owned by the authenticated account.
    
</dd>
</dl>

<dl>
<dd>

**$id:** `int` — ID is the server-assigned unique identifier for the URL forwarding record (returned in list responses).
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;deleteUrlForwardingById($domainName, $id)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Removes a URL forwarding configuration by ID. The domain must be owned by the authenticated account. This operation cannot be undone.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->deleteUrlForwardingById(
    'example.com',
    12345,
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain that owns the URL forwarding entry. Must be owned by the authenticated account.
    
</dd>
</dl>

<dl>
<dd>

**$id:** `int` — ID is the server-assigned unique identifier for the URL forwarding record (returned in list responses).
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;urlForwardings-&gt;updateUrlForwardingById($domainName, $id, $request) -> ?UrlForwardingResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Modifies an existing URL forwarding rule by ID.  The domain must be owned by the authenticated account. Changes may take up to 24 hours to fully propagate.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->urlForwardings->updateUrlForwardingById(
    'example.com',
    12345,
    new UpdateUrlForwardingByIdRequest([
        'body' => new UrlForwardingInput([
            'forwardsTo' => 'https://destination-site.com',
            'host' => 'www',
            'type' => UrlForwardingInputType::Masked->value,
        ]),
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain that owns the URL forwarding entry. Must be owned by the authenticated account.
    
</dd>
</dl>

<dl>
<dd>

**$id:** `int` — ID is the server-assigned unique identifier for the URL forwarding record (returned in list responses).
    
</dd>
</dl>

<dl>
<dd>

**$request:** `UrlForwardingInput` 
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Vanity Nameservers
<details><summary><code>$client-&gt;vanityNameservers-&gt;listVanityNameservers($domainName, $request) -> ?ListVanityNameserversResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Lists all vanity nameserver hostnames configured for a domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->vanityNameservers->listVanityNameservers(
    'example.com',
    new ListVanityNameserversRequest([
        'perPage' => 50,
        'page' => 2,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — The domain name to list vanity nameservers for.
    
</dd>
</dl>

<dl>
<dd>

**$perPage:** `?int` — The number of records to return per page. Defaults to 500.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — The page number to return.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;vanityNameservers-&gt;createVanityNameserver($domainName, $request) -> ?VanityNameserverResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Register a new vanity nameserver for the specified domain.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->vanityNameservers->createVanityNameserver(
    'example.com',
    new CreateVanityNameserverBody([
        'hostname' => 'ns1',
        'ips' => [
            '192.168.1.10',
            '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
        ],
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — The domain name to create a vanity nameserver for.
    
</dd>
</dl>

<dl>
<dd>

**$hostname:** `string` — The subdomain portion of the nameserver hostname. The domain portion will be  taken from the URL path. For example, to create 'ns1.example.com', specify 'ns1'  when calling the endpoint for the domain 'example.com'.
    
</dd>
</dl>

<dl>
<dd>

**$ips:** `array` — IPs is a list of IP addresses that are used for glue records for this nameserver. These should be valid IPv4 or IPv6 addresses.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;vanityNameservers-&gt;getVanityNameserver($domainName, $hostname) -> ?VanityNameserverResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves details for a of a specific vanity nameserver (including its IP addresses).
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->vanityNameservers->getVanityNameserver(
    'example.com',
    'ns1.example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — The domain name associated with the vanity nameserver.
    
</dd>
</dl>

<dl>
<dd>

**$hostname:** `string` — The hostname of the vanity nameserver to retrieve.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;vanityNameservers-&gt;updateVanityNameserver($domainName, $hostname, $request) -> ?VanityNameserverResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Updates the glue record IP addresses for a vanity nameserver.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->vanityNameservers->updateVanityNameserver(
    'example.com',
    'ns1.example.com',
    new UpdateVanityNameserverBody([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — The domain name associated with the vanity nameserver.
    
</dd>
</dl>

<dl>
<dd>

**$hostname:** `string` — The hostname of the vanity nameserver to update.
    
</dd>
</dl>

<dl>
<dd>

**$ips:** `?array` — IPs is the updated list of IP addresses to be used for glue records for this vanity nameserver. Providing an empty array will remove all existing IPs.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;vanityNameservers-&gt;deleteVanityNameserver($domainName, $hostname)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Deletes a vanity nameserver from the domain’s registry settings. This operation might fail if the registry detects the nameserver is still in use.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->vanityNameservers->deleteVanityNameserver(
    'example.com',
    'ns1.example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — The domain name associated with the vanity nameserver.
    
</dd>
</dl>

<dl>
<dd>

**$hostname:** `string` — The hostname of the vanity nameserver to delete.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Webhook Notifications
<details><summary><code>$client-&gt;webhookNotifications-&gt;getSubscribedNotifications() -> ?ListSubscribedWebhooksResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves all active webhook subscriptions on the account.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->webhookNotifications->getSubscribedNotifications();
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;webhookNotifications-&gt;subscribeToNotification($request) -> ?SubscribeToNotificationResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Creates a webhook subscription to receive real-time notifications about specific domain or account events (e.g. transfer completions, renewals). Pass the callback URL and event types. This allows external systems to stay in sync with name.com changes.
Supported webhook event names:
- `account.credit.balance_change` – account credit balance changes (increases or decreases).
- `domain.lock.status_change` – domain lock added or removed.
- `domain.transfer.status_change` – domain transfer IN to name.com; status updates while name.com is the gaining registrar.
- `domain.transfer_out.status_change` – domain transfer OUT from name.com to another registrar; fires when the domain is removed from the account.
- `domain.transfer.internal_in` - name.com domain transfers in to the subscribing account via internal transfer.
- `domain.transfer.internal_out` - name.com domain transfers out of the subscribing account via internal transfer.
- `contact.verification.status_change` - contact verification status changes (verified or unverified).
- `domain.registry.rejection` – domain **create** failed after asynchronous registry processing (uncommon; most creates succeed at request time).
- `domain.expiration` – domain has expired and entered the post-expiry grace period. This is informational only.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->webhookNotifications->subscribeToNotification(
    new SubscribeToNotification([
        'eventName' => AvailableWebhooks::AccountCreditBalanceChange->value,
        'url' => 'https://example.com',
        'active' => true,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$eventName:** `string` 
    
</dd>
</dl>

<dl>
<dd>

**$url:** `string` — The URL we will send the notification data to
    
</dd>
</dl>

<dl>
<dd>

**$active:** `bool` — If the webhook should be active. This allows a webhook to be deactivated in our system. It may be useful to deactivate a webhook if the server that receives the POST request is undergoing scheduled maintenance, for example.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;webhookNotifications-&gt;modifySubscription($id, $request) -> ?ModifySubscriptionResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Updates an existing webhook’s configuration.  This may include changing the callback URL or updating whether the webhook is currently active.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->webhookNotifications->modifySubscription(
    1,
    new ModifySubscriptionRequest([
        'body' => new ModifySubscriptionRequestBodyUrl([
            'url' => 'url',
        ]),
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$id:** `int` — ID of the subscription to update.
    
</dd>
</dl>

<dl>
<dd>

**$request:** `ModifySubscriptionRequestBodyUrl|ModifySubscriptionRequestBodyActive` 
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;webhookNotifications-&gt;deleteSubscription($id)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Removes a webhook subscription from the account.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->webhookNotifications->deleteSubscription(
    1,
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$id:** `int` — ID of the subscription to delete.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Orders
<details><summary><code>$client-&gt;orders-&gt;listOrders($request) -> ?ListOrdersResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves a list of all orders placed in the account.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->orders->listOrders(
    new ListOrdersRequest([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$perPage:** `?int` — Per Page is the number of records to return per request. Per Page defaults to 500.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return.
    
</dd>
</dl>

<dl>
<dd>

**$dir:** `?string` — Dir indicates direction of list order. Possible values are 'asc' (default) or 'desc'.
    
</dd>
</dl>

<dl>
<dd>

**$domainName:** `?string` — DomainName filters orders by domain name. Supports exact match or wildcard (starts with '*').
    
</dd>
</dl>

<dl>
<dd>

**$tld:** `?string` — Tld filters orders by tld.
    
</dd>
</dl>

<dl>
<dd>

**$createDateStart:** `?string` — CreateDateStart filters orders created on or after this date.
    
</dd>
</dl>

<dl>
<dd>

**$createDateEnd:** `?string` — CreateDateEnd filters orders created on or before this date.
    
</dd>
</dl>

<dl>
<dd>

**$type:** `?string` — Type filters orders by order item type (e.g., 'registration', 'renewal', 'transfer', 'whois_privacy').
    
</dd>
</dl>

<dl>
<dd>

**$orderStatus:** `?string` — OrderStatus filters orders by status.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;orders-&gt;getOrder($orderId) -> ?Order</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Fetches full details about a specific order using its ID. This includes domains, prices, and timestamps.  Useful for confirming transactions, receipts, or generating invoices.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->orders->getOrder(
    1,
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$orderId:** `int` — OrderId is the unique identifier of the requested order.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Refunds
<details><summary><code>$client-&gt;refunds-&gt;processRefund($request) -> ?RefundResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Deletes eligible domains and security products during the Add Grace Period (AGP) and automatically issues refunds for the associated order items.

### Eligibility Requirements

- **Product Types**: Only `registration` and `whois_privacy` product types are eligible for refunds.
- **AGP Timing**: Items must be within the Add Grace Period (typically 5 days from registration, varies by TLD).
- **Order Ownership**: All `orderItemIds` must belong to the specified `orderId`.

### Refund Processing

Refunds are processed in the following order:
1. Domain deletion is attempted for each eligible order item
2. Upon successful deletion, the refund is issued
3. Refunds are sent to the original payment method on file
4. If the original payment method is unavailable, the refund is credited to the account balance

### Idempotency

This endpoint supports idempotent requests via the `X-Idempotency-Key` header. If you retry a request with the same idempotency key, you will receive the same response as the original request. This is useful for safely retrying requests without risk of processing duplicate refunds.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->refunds->processRefund(
    new RefundRequest([
        'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
        'orderId' => 123456,
        'orderItemIds' => [
            987654,
        ],
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$idempotencyKey:** `?string` — A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result. Idempotency keys are valid for 12 hours.
    
</dd>
</dl>

<dl>
<dd>

**$orderId:** `int` — The unique identifier of the order containing the item(s) to be refunded. Use the List Orders endpoint to retrieve order IDs.
    
</dd>
</dl>

<dl>
<dd>

**$orderItemIds:** `array` — An array of order item IDs to be refunded. All items must belong to the specified order. Use the List Orders endpoint to retrieve order item IDs.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Transfers
<details><summary><code>$client-&gt;transfers-&gt;listTransfers($request) -> ?ListTransfersResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns all domain transfer requests for the account, including in-progress and recent transfers.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->transfers->listTransfers(
    new ListTransfersRequest([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$perPage:** `?int` — Per Page is the number of records to return per request. Per Page defaults to 500.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;transfers-&gt;createTransfer($request) -> ?CreateTransferResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Initiates a domain transfer into your name.com account from another registrar. You must provide the domain name and its valid transfer authorization code (EPP code). The domain must not be locked or under any transfer restrictions (e.g. clientTransferProhibited). If successful, the transfer is submitted and tracked through the ICANN transfer process. Once a transfer has been created, you can track its progress via the [GetTransfer](/api/v1/reference/transfers/get-transfer) endpoint.
**Transfer pricing:** Omit `purchasePrice` for standard (non-premium) transfers. For premium transfers, pass `transferPrice` from [Get Pricing For Domain](/api/v1/reference/domains/get-pricing-for-domain) as `purchasePrice`. If sent, it must match Get Pricing `transferPrice` exactly or the request will fail. Premium transfers without `purchasePrice` will fail. See the [Domain pricing guide](/guides/domain-pricing) for how [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) `transferPrice` relates to the `years` query parameter.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->transfers->createTransfer(
    new CreateTransferRequest([
        'authCode' => 'ABC123',
        'domainName' => 'example.com',
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$authCode:** `string` — AuthCode is the authorization code for the transfer. Not all TLDs require authorization codes, but most do.
    
</dd>
</dl>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain you want to transfer to name.com.
    
</dd>
</dl>

<dl>
<dd>

**$privacyEnabled:** `?bool` — PrivacyEnabled is a flag on whether to purchase Whois Privacy with the transfer. If this flag is omitted from the request, the system will check the account's Whois Privacy auto-add settings. If auto-add is enabled in your account settings, Whois Privacy will be added by default, provided the TLD supports it.
    
</dd>
</dl>

<dl>
<dd>

**$purchasePrice:** `?float` — PurchasePrice is the USD inbound transfer fee, before VAT. VAT is applied when applicable and must not be included here. If sent, must match Get Pricing `transferPrice` exactly or the request will fail.. **Omit** for standard (non-premium) transfers. **Required** for premium transfers — use `transferPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain).
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;transfers-&gt;getTransfer($domainName) -> ?Transfer</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Retrieves details of a specific domain transfer request.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->transfers->getTransfer(
    'domainName',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain you want to get the transfer information for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;transfers-&gt;cancelTransfer($domainName) -> ?Transfer</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Cancels a pending transfer request. This can be used if the transfer was initiated in error or if the authorization code provided was incorrect.
The price of the transfer will refund the amount to account credit.

Cancelable statuses:
- pending
- submitting_transfer
- pending_new_auth_code
- pending_unlock
- pending_registry_unlock
- rejected

Non-cancelable statuses:
- pending_transfer
- pending_insert
- completed
- failed
- canceled
- canceled_pending_refund
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->transfers->cancelTransfer(
    'domainName',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain to cancel the transfer for.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;transfers-&gt;cancelOutboundTransfer($domainName) -> ?CancelTransferOutResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Cancels an outbound transfer for the given domain. Use this when the domain is being transferred out of name.com (losing registrar) to another (gaining) registrar and the registrant or reseller wants to cancel that transfer.
The endpoint validates that the domain exists and belongs to the authenticated account. Only domains in a pending transfer (out) state can be canceled.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->transfers->cancelOutboundTransfer(
    'example.com',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — DomainName is the domain whose transfer out should be canceled.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;transfers-&gt;createInternalTransferIn($request) -> ?DomainResponsePayload</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Pulls a domain from another [name.com](https://www.name.com) account into your reseller (gaining) account using a valid authorization code. This is an **internal** name.com-to-name.com move; it is separate from [Create Transfer](/api/v1/reference/transfers/create-transfer), which brings domains in from **external** registrars.
Check if a TLD is eligible for internal transfer in by calling [Tld Requirements](/api/v1/reference/domaininfo/requirementsV2) for the TLD and checking property `supportsInternalTransfer`.
This API is only available to approved reseller accounts. Contact name.com support to request access.
#### Losing account (dashboard only)
The party that holds the domain today must use the name.com dashboard on the **losing** account to **unlock** the domain (remove registrar transfer lock) and to **copy the authorization code** to provide to your integration. This endpoint does not unlock the domain or retrieve the auth code for the losing account.
#### Gaining account (this API)
Call this endpoint with `domainName`, `authCode`, and optional `contacts` using the **gaining** reseller's API credentials.
#### Contacts and post-transfer lock
If `contacts` is omitted, the gaining account's default contacts are applied. If `contacts` is provided, any roles included in the request are applied and omitted roles use the gaining account's default contacts (same pattern as [Create Domain](/api/v1/reference/domains/create-domain) and [Set Contacts](/api/v1/reference/domains/set-contacts)). The 60-day contact-change transfer lock is enforced based on the **gaining** account's settings, consistent with Set Contacts.
#### Access
Restricted to approved enterprise resellers; other callers receive `403 Forbidden`.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->transfers->createInternalTransferIn(
    new CreateInternalTransferInRequest([
        'domainName' => 'example.com',
        'authCode' => 'ABC123',
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — Fully qualified domain name to transfer in. The domain must be registered in another name.com account (the losing account).
    
</dd>
</dl>

<dl>
<dd>

**$authCode:** `string` — Transfer authorization code (EPP/auth code) for the domain. The losing account holder must obtain this code from the [name.com](https://www.name.com) dashboard; it is not exposed by this API for the losing account.
    
</dd>
</dl>

<dl>
<dd>

**$contacts:** `?ContactsRequest` — WHOIS contacts to apply after the transfer. If omitted, the gaining account's default contacts are applied. If provided, include any roles to override; omitted roles use the gaining account's default contacts. Each supplied role must include complete contact fields. A registrar contact-change transfer lock may apply according to the gaining account's settings, consistent with the Set Contacts endpoint.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;transfers-&gt;getTransferEligibility($domainName) -> ?TransferEligibilityResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns whether a domain is currently registered at [name.com](https://www.name.com) and whether the TLD supports internal transfer between name.com accounts. Use this to decide whether to send your user through the [Create Transfer](/api/v1/reference/transfers/create-transfer) external transfer flow or the [Create Internal Transfer In](/api/v1/reference/transfers/create-internal-transfer-in) flow before initiating a transfer-in.

#### Response semantics

`atName` is `true` if the domain is currently registered at name.com in any account. This information is also publicly available via RDAP.

`supportsInternalTransfer` mirrors the TLD-level value returned by [Tld Requirements](/api/v1/reference/domain-info/get-specific-tld-requirements). It indicates whether the TLD is eligible for internal transfer between name.com accounts. It does not reflect per-account allowlist eligibility — if your account is not allowlisted for internal transfer in, calling [Create Internal Transfer In](/api/v1/reference/transfers/create-internal-transfer-in) will return `403 Forbidden`.

#### Privacy

This endpoint never reveals which account a domain is in. To check whether a domain is in your own account, use [Get Domain](/api/v1/reference/domains/get-domain) instead.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->transfers->getTransferEligibility(
    'domainName',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domainName:** `string` — The domain to check transfer eligibility for. Punycode is normalized server-side, so either ASCII or UTF-8 is accepted.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Domain Info
<details><summary><code>$client-&gt;domainInfo-&gt;getRequirement($tld) -> ?GetRequirementResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns the registration requirements some general information for a specific TLD. The response contains a detailed description of eligibility criteria and a fields object with all required and optional fields, including validation rules, conditional logic, and nested field structures. Provide the TLD as a path parameter to retrieve its complete registration requirements. Useful when you only need details for one TLD (e.g., when a user selects .fr from a dropdown).
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domainInfo->getRequirement(
    'fr',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$tld:** `string` — TLD indicates which domain requirements to retrieve (without the dot prefix, e.g., 'fr' for .fr domains). For punycode TLDs, use the ASCII version instead of the UTF-8. So for the `онлайн` TLD, you would submit `xn--80asehdb`.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domainInfo-&gt;checkDomainClaims($domain, $request) -> ?DomainClaimsCheckResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Performs the actual claims check for a specific domain. This endpoint checks if a specific domain has trademark claims against it, returning detailed information about any matching trademarks and their holders. Use this to verify if a domain can be registered without trademark conflicts. Please see the [claims flow](/guides/claims-flow) for information on how to use this endpoint in your domain purchase flow.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domainInfo->checkDomainClaims(
    'tiktok.page',
    new DomainClaimsCheckRequest([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$domain:** `string` — The domain name to check for trademark claims (e.g., 'tiktok.page', 'example.com'). Include the full domain name including the TLD.
    
</dd>
</dl>

<dl>
<dd>

**$purchaseType:** `?string` — The type of purchase/registration for which to check claims. Defaults to 'registration'. Other values like 'landrush_eap', 'landrush_auction_a', 'landrush_reserve_a' may be used during new gTLD launches.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;domainInfo-&gt;getTldRequirementsV2($tld) -> ?RequirementsJsonSchema</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns the registration requirements as a JSON Schema (Draft 7) document. This endpoint is designed for form generation and validation libraries that consume JSON Schema directly.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->domainInfo->getTldRequirementsV2(
    'fr',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$tld:** `string` — TLD indicates which domain requirements to retrieve (without the dot prefix, e.g., 'fr' for .fr domains). For punycode TLDs, use the ASCII version instead of the UTF-8. So for the `онлайн` TLD, you would submit `xn--80asehdb`.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## TLD Pricing
<details><summary><code>$client-&gt;tldPricing-&gt;tldPriceList($request) -> ?TldPriceListResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

This endpoint returns an alphabetical list of all TLDs supported by name.com, including pricing for each supported order type. All prices are in US Dollars (USD) and apply to non-premium domains. name.com provides three pricing types for each TLD:
- Account-Level Pricing - Your price, including any applicable rebates, promotions, or account-level discounts. This is referenced as 'registrationprice', 'renewalprice', 'transferinprice' and 'domainrestorationprice' in this endpoint.
- Original Pricing (No Discounts Applied) - The suggested retail price (MSRP) before any discounts are applied.
- Retail Pricing (Public Site Pricing) - The current public retail price on name.com, including any public rebates or promotions, but before any account-level discounts.

**Important Notes:**
- Promo codes are not supported through the API, and therefore are not reflected in any pricing values returned.
- General TLD pricing only: This represents standard pricing for domains registered under the specified TLD. Pricing for specific domains may differ based on multiple factors (e.g., premium classifications, registry pricing rules). To retrieve pricing for an individual domain, use the GetPricingForDomain endpoint.
- Availability: If a pricing value is returned as null, that product type is not currently supported for the TLD. (Example: registrationPrice = null means registrations are not currently available.)
- If you do not have account level pricing, the retail price will always match your account level price. (e.g., registration price = registration retail price)
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->tldPricing->tldPriceList(
    new TldPriceListRequest([
        'duration' => 1,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$perPage:** `?int` — Per Page is the number of records to return per request. Per Page defaults to 25.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return.
    
</dd>
</dl>

<dl>
<dd>

**$duration:** `?int` — The number of years to get pricing for. The requested duration must be between 1 and 10 (inclusive). If the duration is not passed in the request, it will default to 1.
    
</dd>
</dl>

<dl>
<dd>

**$tlds:** `?string` — A list of specific TLDs to get pricing for. Maximum of 25 TLDs can be requested at a time.  When querying for IDN TLDs, due to character restrictions within a URL, they must be submitted in ASCII format.  This means using "xn--9dbq2a" as opposed to it's unicode equivalent. The submitted TLDs will be checked for validity and support at name.com, and any invalid TLD will be removed from the submitted list. If all submitted TLDs are invalid or not supported by name.com, this will be considered a bad request, and a `400 Bad Request` will be returned with an appropriate message.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Premium Domains
<details><summary><code>$client-&gt;premiumDomains-&gt;premiumDomainLists() -> ?PremiumDomainsDownloadResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Gets a pre-signed URL that will allow a user to download a list of premium domains, with their registration and renewal pricing.
**Please Note:** The pre-signed URL will only be valid for 10 minutes. This endpoint is only available to approved reseller accounts. Contact name.com support to request access.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->premiumDomains->premiumDomainLists();
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Contact Verification
<details><summary><code>$client-&gt;contactVerification-&gt;unverifiedContactsList($request) -> ?UnverifiedContactsResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns a list of contacts, related to domains within your account, that require verification as per ICANN procedures.
When a new domain is created, unverified contacts are not immediately available in API responses.  Records are added by a scheduled process that runs approximately every 10 minutes.  As a result, there may be up to a 10-minute delay before unverified contacts appear in the API. This delay also applies to related events such as webhooks or other downstream systems that depend on contact verification data. 
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->contactVerification->unverifiedContactsList(
    new UnverifiedContactsListRequest([
        'perPage' => 100,
        'page' => 2,
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$perPage:** `?int` — PerPage is the number of records to return per request. If not passed in the request, the default value is 100 records.
    
</dd>
</dl>

<dl>
<dd>

**$page:** `?int` — Page is which page to return. If not passed in the request, the default page is 1.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;contactVerification-&gt;verifyContact($verificationId, $request)</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Use this API to verify a contact.
This API is only available to approved reseller accounts. Contact name.com support to request access.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->contactVerification->verifyContact(
    1,
    new VerifyContactRequest([
        'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$verificationId:** `int` — The VerificationId required to verify a specific contact.
    
</dd>
</dl>

<dl>
<dd>

**$idempotencyKey:** `?string` — A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;contactVerification-&gt;resendContactVerificationEmail($verificationId, $request) -> ?ContactVerificationResendResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Resend the contact verification email for a pending verification record.

### Throttling
This endpoint enforces strict throttling to prevent abuse:
- Per `verificationId`: max 1 resend per 15 minutes
- Per reseller account: max 200 resends per rolling hour

`nextEligibleAt` is always returned so the client knows when it can try again.

On `429`, the response uses the standard error envelope, and `details` contains the earliest retry time (RFC3339 UTC).
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->contactVerification->resendContactVerificationEmail(
    1,
    new ResendContactVerificationEmailRequest([
        'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
    ]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$verificationId:** `int` — The verificationId for the pending contact verification record.
    
</dd>
</dl>

<dl>
<dd>

**$idempotencyKey:** `?string` — A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

