# mailingwork

## Installation

This project is not published on packagist till now.

```
composer require bconnect/mailingwork
```

## Usage

```php
$client = \bconnect\MailingWork\Client::getClient('user', 'pass');
try {
  $listId = $client->api('list')->createList("Api created list");
  $recipient = $client->api('recipient')->getRecipientById(5);
} catch (\bconnect\MailingWork\ApiException $ex) {
  print "Error ocurred";
}
```

## Clients

* [ListClient](/doc/ListClient.md)
* [RecipientClient](/doc/RecipientClient.md)
* [SelectionClient](/doc/SelectionClient.md)
* [TargetGroupClient](/doc/TargetGroupClient.md)
