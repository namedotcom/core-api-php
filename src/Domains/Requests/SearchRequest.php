<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;
use Namecom\Types\SearchPurchaseType;

class SearchRequest extends JsonSerializableType
{
    /**
     * @var string $keyword Keyword is the search term to search for. It can be just a word, or a whole domain name.
     */
    #[JsonProperty('keyword')]
    public string $keyword;

    /**
     * Timeout is a value in milliseconds on how long to perform the search for. Valid timeouts are between 500ms to 12,000ms. If not specified, timeout defaults to 12,000ms.
     * Since some additional processing is performed on the results, a response may take longer then the timeout.
     *
     * @var ?int $timeout
     */
    #[JsonProperty('timeout')]
    public ?int $timeout;

    /**
     * @var ?array<string> $tldFilter TLDFilter will limit results to only contain the specified TLDs. There is a maximum of 50 TLDs that can be used in this filter
     */
    #[JsonProperty('tldFilter'), ArrayType(['string'])]
    public ?array $tldFilter;

    /**
     * @var ?value-of<SearchPurchaseType> $purchaseType Optional. Limits results to the given `purchaseType`. **Recommended:** `registration` for most integrations — omit only if you choose to support acquisition types. See the [Domain purchase pricing guide](/guides/domain-pricing).
     */
    #[JsonProperty('purchaseType')]
    public ?string $purchaseType;

    /**
     * @param array{
     *   keyword: string,
     *   timeout?: ?int,
     *   tldFilter?: ?array<string>,
     *   purchaseType?: ?value-of<SearchPurchaseType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->keyword = $values['keyword'];
        $this->timeout = $values['timeout'] ?? null;
        $this->tldFilter = $values['tldFilter'] ?? null;
        $this->purchaseType = $values['purchaseType'] ?? null;
    }
}
