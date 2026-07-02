<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class HelloResponse extends JsonSerializableType
{
    /**
     * @var string $motd Motd is a message of the day. It might provide some useful information.
     */
    #[JsonProperty('motd')]
    public string $motd;

    /**
     * @var string $serverName ServerName is an identfier for which server is being accessed.
     */
    #[JsonProperty('serverName')]
    public string $serverName;

    /**
     * @var string $serverTime ServerTime is the current date/time at the server.
     */
    #[JsonProperty('serverTime')]
    public string $serverTime;

    /**
     * @var string $username Username is the account name you are currently logged into.
     */
    #[JsonProperty('username')]
    public string $username;

    /**
     * @param array{
     *   motd: string,
     *   serverName: string,
     *   serverTime: string,
     *   username: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->motd = $values['motd'];
        $this->serverName = $values['serverName'];
        $this->serverTime = $values['serverTime'];
        $this->username = $values['username'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
