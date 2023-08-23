
# Triple-A Payment SDK for Laravel

Enjoy the benefits of accepting cryptocurrencies without having to hold or convert cryptocurrencies, with zero-volatility and next-day bank settlement.

The package offers the following:

 - Triple A Crypto Payment
 - Refund Crypto Payment

# installation

Install the package via composer: `composer require triplea/triplea`

### Config Files

In order to edit the default configuration you may execute:

```
php artisan vendor:publish --tag=triplea-config --force
```
After that, `config/triplea.php` will be created.

Add config value in your `.env`

```php
//.env
TRIPLEA_CLIENT_ID=oacid-************************
TRIPLEA_CLIENT_SECRET=************************************
TRIPLEA_MERCHANT_KEY=mkey-***********************
TRIPLEA_SANDBOX=true
TRIPLEA_PAYMENT_TYPE=widget
```

Register on Triple-A Platform to get client id, client secret and merchant key.
<a href="https://triple-a.io/signup/">Register here.</a>

## Usage

#### Create Payer using Payer Model
```php
//use Topup\Triplea\Models\Payer;

// Payer ID, Payer Name, Payer Email, Payer Phone, Payer Address
$payer = new  Payer('payer_id', 'payer_name', 'payer@mail.com', '+6591234567', '123, streat, 1207');
```


#### Create Item using Item Model
```php
//use Topup\Triplea\Models\Item;

// Item SKU, Item Name/Label, Quantity, Amount
$item = new Item('sku', 'Label Name', 1, 10);

```

#### Make Payment

- `setOrderId()` set your unique order ID
- `setPayer()` set Payer `PAYER_ID` is required.
- `addItem()` add Item to your payment. Minimum 1 item is required.
- `setOrderAmount()` set amount for the payment.
- `setSuccessUrl()` set Your success url. It's will redirect you after the successful payment.
- `setCancelUrl()` it's will redirect you if you cancel the payement.
- `setNotifyUrl()` is the webhook url.
- `setNotifyEmail()` set your email to get transaction notification.
- `setNotifySecret()` optional - add secret key to verify and validate your webhook call.

```php
$triplea = new  Triplea();
$response = $triplea->payment->setOrderId("UNIQUE_ORDER_ID")->setPayer($payer)->addItem($item)->setOrderAmount(12)->setSuccessUrl('http://success.io')->setCancelUrl('http://cancel.io')->setNotifyUrl('https://webhook.site/35a28e54-a6a7-4834-8d82-df7eb0780379')->setNotifyEmail('35a28e54-a6a7-4834-8d82-df7eb0780379@email.webhook.site')->create();
```


#### Add multiple item in payment

You can use loop to add multiple items in your payment.

```php
// use Topup\Triplea\Triplea;

$triplea = new  Triplea();

foreach($items as $item) {
	$triplea->payment->addItem(new  Item($item->sku, $item->label, $item->quantity, $item->amount));
}
```

### Get Payment Details

To get payment details use `getDetails()` and pass `PAYMENT_REFERENCE` 
```php
// use Topup\Triplea\Triplea;

$triplea = new  Triplea();
$response = $triplea->payment->getDetails('PAYMENT_REFERENCE');
```

### Initialize Refund

- `setPaymentReference()` set The payment reference to initialize the refund of the payment.
- `setEmail()` set The payer email to get refund url.
- `setRefundAmount()` set Exact refund amount of the payment.

```php
// use Topup\Triplea\Triplea;

$triplea = new  Triplea();

$response = $triplea->refund->setPaymentReference('PAYMENT_REFERENCE')>setEmail('PAYER_EMAIL_TO_GET_REFUND_LINK')->setRefundAmount(12)->setNotifyUrl('https://webhook.site/35a28e54-a6a7-4834-8d82-df7eb0780379')->setRemarks("Refund for the order")->create();
```

### Get Refund Details
```php
// use Topup\Triplea\Triplea;

$triplea = new  Triplea();
$response = $triplea->refund->refundDetails('PAYMENT_REFERENCE');
```

### Cancel The Refund request
```php
// use Topup\Triplea\Triplea;

$triplea = new  Triplea();
$response = $triplea->refund->refundCancel('PAYOUT_REFERENCE');
```