# customer.io bundle

[![Build Status](https://travis-ci.org/symfonylab/customerio-bundle.svg?branch=master)](https://travis-ci.org/symfonylab/customerio-bundle)

[![Latest Stable Version](https://poser.pugx.org/symfonylab/customerio-bundle/v/stable.svg)](https://packagist.org/packages/symfonylab/customerio-bundle) [![Total Downloads](https://poser.pugx.org/symfonylab/customerio-bundle/downloads.svg)](https://packagist.org/packages/symfonylab/customerio-bundle) [![License](https://poser.pugx.org/symfonylab/customerio-bundle/license.svg)](https://packagist.org/packages/symfonylab/customerio-bundle)



Symfony integration for http://customer.io.


## Configuration

Install the bundle using composer and register it in your Kernel.

Then configure your `site_id`  and `api_key`:


```yml
# app/config/config.yml

symfonylab_customer_io:
  site_id: <YOUR-SITE-ID>
  api_key: <YOUR-API-KEY>

```

## Usage

### Customer model

Implement `SymfonyLab\CustomerIOBundle\Model\CustomerInterface` on your customer domain class.

### Event Tracking / Customer identification

```php

use SymfonyLab\CustomerIOBundle\Event\TrackingEvent;
use SymfonyLab\CustomerIOBundle\Event\ActionEvent;

/** @var \Symfony\Component\EventDispatcher\EventDispatcher $tracker */
$dispatcher = $this->getContainer()->get('event_dispatcher');

$customer = $repo->getCustomer(); // retrieve your customer domain object

// send the customer over to customer.io for identification
$dispatcher->dispatch(new TrackingEvent($customer));

// now track a `click` event
$dispatcher->dispatch(new ActionEvent($customer, 'click'));

```


### Webhooks


The bundle comes with a controller which can consume customer.io [webhooks](http://customer.io/docs/webhooks.html).

To use them, register the routing.xml:

```yml
# app/config/routing.yml

customerio_hooks:
    resource: "@SymfonyLabCustomerIOBundle/Resources/config/routing.yaml"

```

Now your hook url will be `http://your.project.com/webhook` which you
need to configure over at customer.io.

After doing so, you can listen to webhook events:


```xml

<service id="acme.webhooklistener" class="Acme\DemoBundle\Listener\WebhookListener">
    <tag name="kernel.event_listener" event="customer_io.email_clicked" method="onClick" />
</service>

```

```php

use SymfonyLab\CustomerIOBundle\Event\WebHookEvent;

class WebhookListener
{
    public function onClick(WebHookEvent $event)
    {
        $this->logger->info('Customer clicked on email with address: ' . $event->getEmail());
    }
}

```
