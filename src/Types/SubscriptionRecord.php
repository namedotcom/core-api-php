<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class SubscriptionRecord extends JsonSerializableType
{
    /**
     * @var bool $active
     */
    #[JsonProperty('active')]
    public bool $active;

    /**
     * @var string $createDate
     */
    #[JsonProperty('createDate')]
    public string $createDate;

    /**
     * @var string $eventName
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var int $id
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var ?string $updateDate
     */
    #[JsonProperty('updateDate')]
    public ?string $updateDate;

    /**
     * @var string $url
     */
    #[JsonProperty('url')]
    public string $url;

    /**
     * @param array{
     *   active: bool,
     *   createDate: string,
     *   eventName: string,
     *   id: int,
     *   url: string,
     *   updateDate?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->active = $values['active'];
        $this->createDate = $values['createDate'];
        $this->eventName = $values['eventName'];
        $this->id = $values['id'];
        $this->updateDate = $values['updateDate'] ?? null;
        $this->url = $values['url'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
