# Namecom PHP Library

[![fern shield](https://img.shields.io/badge/%F0%9F%8C%BF-Built%20with%20Fern-brightgreen)](https://buildwithfern.com?utm_source=github&utm_medium=github&utm_campaign=readme&utm_source=https%3A%2F%2Fgithub.com%2Fnamedotcom%2Fcore-api-php)
[![php shield](https://img.shields.io/badge/php-packagist-pink)](https://packagist.org/packages/namecom/core-api)

Official SDK for the name.com Core API.

List endpoints are paginated: use the `page` and `perPage` query parameters.
Responses include `totalCount`, `nextPage`, and `lastPage`, and most list
endpoints also return a `Link` header with `next`/`prev`/`last` URLs.

Write endpoints that accept an idempotency key are safe to retry — reusing
the same key returns the original result instead of repeating the operation.

See https://docs.name.com for full guides and the API reference.


## Table of Contents

- [Documentation](#documentation)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Environments](#environments)
- [Exception Handling](#exception-handling)
- [Advanced](#advanced)
  - [Custom Client](#custom-client)
  - [Retries](#retries)
  - [Timeouts](#timeouts)
- [Contributing](#contributing)

## Documentation

API reference documentation is available [here](https://docs.name.com).

## Requirements

This SDK requires PHP ^8.1.

## Installation

```sh
composer require namecom/core-api
```

## Usage

Instantiate and use the client with the following:

```php
<?php

namespace Example;

use Namecom\NamecomClient;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->hello();

```

```php
<?php

namespace Example;

use Namecom\NamecomClient;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->accountInfo->checkAccountBalance();

```

```php
<?php

namespace Example;

use Namecom\NamecomClient;
use Namecom\Domains\Requests\SearchRequest;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->domains->search(
    new SearchRequest([
        'keyword' => 'mydomain',
    ]),
);

```

```php
<?php

namespace Example;

use Namecom\NamecomClient;
use Namecom\Domains\Requests\CreateDomainRequest;
use Namecom\Types\DomainCreatePayload;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->domains->createDomain(
    new CreateDomainRequest([
        'domain' => new DomainCreatePayload([
            'domainName' => 'example.com',
        ]),
    ]),
);

```

```php
<?php

namespace Example;

use Namecom\NamecomClient;
use Namecom\Domains\Requests\ListDomainsRequest;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->domains->listDomains(
    new ListDomainsRequest([]),
);

```

```php
<?php

namespace Example;

use Namecom\NamecomClient;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->domains->getDomain(
    'example.com',
);

```

```php
<?php

namespace Example;

use Namecom\NamecomClient;
use Namecom\Dns\Requests\ListRecordsRequest;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->dns->listRecords(
    'domainName',
    new ListRecordsRequest([]),
);

```

```php
<?php

namespace Example;

use Namecom\NamecomClient;
use Namecom\Dns\Requests\DnsCreateRecordBody;
use Namecom\Dns\Types\DnsCreateRecordBodyType;

$client = new NamecomClient(
    username: '<username>',
    password: '<password>',
);
$client->dns->createRecord(
    'domainName',
    new DnsCreateRecordBody([
        'answer' => 'answer',
        'host' => 'host',
        'type' => DnsCreateRecordBodyType::A->value,
    ]),
);

```

## Environments

This SDK allows you to configure different environments for API requests.

```php
The SDK defaults to the `Sandbox` environment. To use a different environment, pass it to the client constructor:

```php
use Namecom\NamecomClient;
use Namecom\Environments;

$client = new NamecomClient(
    token: '<YOUR_TOKEN>',
    options: [
        'baseUrl' => Environments::Staging->value
    ]
);
```

Available environments:
- `Environments::Sandbox`
- `Environments::Production`
```

## Exception Handling

When the API returns a non-success status code (4xx or 5xx response), an exception will be thrown.

```php
use Namecom\Exceptions\NamecomApiException;
use Namecom\Exceptions\NamecomException;

try {
    $response = $client->hello(...);
} catch (NamecomApiException $e) {
    echo 'API Exception occurred: ' . $e->getMessage() . "\n";
    echo 'Status Code: ' . $e->getCode() . "\n";
    echo 'Response Body: ' . $e->getBody() . "\n";
    // Optionally, rethrow the exception or handle accordingly.
}
```

## Advanced

### Custom Client

This SDK is built to work with any HTTP client that implements the [PSR-18](https://www.php-fig.org/psr/psr-18/) `ClientInterface`.
By default, if no client is provided, the SDK will use `php-http/discovery` to find an installed HTTP client.
However, you can pass your own client that adheres to `ClientInterface`:

```php
use Namecom\NamecomClient;

// Pass any PSR-18 compatible HTTP client implementation.
// For example, using Guzzle:
$customClient = new \GuzzleHttp\Client([
    'timeout' => 5.0,
]);

$client = new NamecomClient(options: [
    'client' => $customClient
]);

// Or using Symfony HttpClient:
// $customClient = (new \Symfony\Component\HttpClient\Psr18Client())
//     ->withOptions(['timeout' => 5.0]);
//
// $client = new NamecomClient(options: [
//     'client' => $customClient
// ]);
```

### Retries

The SDK is instrumented with automatic retries with exponential backoff. A request will be retried as long
as the request is deemed retryable and the number of retry attempts has not grown larger than the configured
retry limit (default: 2).

A request is deemed retryable when any of the following HTTP status codes is returned:

- [408](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/408) (Timeout)
- [429](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/429) (Too Many Requests)
- [5XX](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#server_error_responses) (Internal Server Error)

The `retryStatusCodes` configuration controls which [5XX](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#server_error_responses) status codes are retried:

- `legacy` (default): Retries `408`, `429`, and all `>= 500`
- `recommended`: Retries `408`, `429`, `502`, `503`, `504` only (excludes `500 Internal Server Error` to avoid retrying non-idempotent failures)

Use the `maxRetries` request option to configure this behavior.

```php
$response = $client->hello(
    ...,
    options: [
        'maxRetries' => 0 // Override maxRetries at the request level
    ]
);
```

### Timeouts

The SDK defaults to a 30 second timeout. Use the `timeout` option to configure this behavior.

```php
$response = $client->hello(
    ...,
    options: [
        'timeout' => 3.0 // Override timeout at the request level
    ]
);
```

## Contributing

While we value open-source contributions to this SDK, this library is generated programmatically.
Additions made directly to this library would have to be moved over to our generation code,
otherwise they would be overwritten upon the next generated release. Feel free to open a PR as
a proof of concept, but know that we will not be able to merge it as-is. We suggest opening
an issue first to discuss with us!

On the other hand, contributions to the README are always very welcome!
