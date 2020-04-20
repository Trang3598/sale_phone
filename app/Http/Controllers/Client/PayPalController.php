<?php

namespace App\Http\Controllers\Client;

use App\Order;
use App\OrderDetail;
use App\Repositories\Repository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;

class PayPalController
{
    private $apiContext;
    private $itemList;
    private $paymentCurrency;
    private $totalAmount;
    private $returnUrl;
    private $cancelUrl;

    private $order_detail, $order;

    public function __construct(OrderDetail $order_detail, Order $order)
    {
        $this->order_detail = new Repository($order_detail);
        $this->order = new Repository($order);
        $paypalConfigs = config('paypal');
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AXQPU_PX8iybnq1rm-CfjqKn_TXvUv07tRO3nZd99Zs1m6T340pg7ZsaJMpn9DXuzaTN1WkuzrvLIE4t',     // ClientID
                'EGwLT1yoAXn6tRKO-kRU80yLdilvGuVUx-mWSiR_zYANx9e3DzJC87gPe3LzRjsI5plXuhJrp9Nerg5L'      // ClientSecret
            )
        );
        $this->paymentCurrency = "USD";
        $this->totalAmount = 0;
    }

    public function setCurrency($currency)
    {
        $this->paymentCurrency = $currency;

        return $this;
    }

    public function getCurrency()
    {
        return $this->paymentCurrency;
    }

    public function setItem($itemData)
    {
        if (count($itemData) === count($itemData, COUNT_RECURSIVE)) {
            $itemData = [$itemData];
        }
        foreach ($itemData as $data) {
            $item = new Item();
            $item->setName($data['name_phone'])
                ->setCurrency($this->paymentCurrency) // Đơn vị tiền của item
                ->setSku($data['sku']) // ID của item
                ->setQuantity($data['quantity']) // Số lượng
                ->setPrice($data['price']); // Giá
            // Thêm item vào danh sách
            $this->itemList[] = $item;
            // Tính tổng đơn hàng
            $this->totalAmount += $data['price'] * $data['quantity'];
        }

        return $this;
    }

    public function createPayment()
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice(7.5);
        $item2 = new Item();
        $item2->setName('Granola bars')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setSku("321321") // Similar to `item_number` in Classic API
            ->setPrice(2);
        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));

        $details = new Details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.50);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://laravel-paypal-example.test")
            ->setCancelUrl("http://laravel-paypal-example.test");
        $inputFields = new InputFields();
        $inputFields->setNoShipping(1);

        $webProfile = new WebProfile();
        $webProfile->setName('test' . uniqid())->setInputFields($inputFields);

        $webProfileId = $webProfile->create($this->apiContext)->getId();

        $payment = new Payment();
        $payment->setExperienceProfileId($webProfileId); // no shipping
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->apiContext);
        } catch (\Exception $ex) {
            echo $ex;
            exit(1);
        }
        return $payment;
    }

    public function executePayment(Request $request)
    {
        $paymentId = $request->paymentID;
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->payerID);
        try {
            $result = $payment->execute($execution, $this->apiContext);
        } catch (\Exception $ex) {
            echo $ex;
            exit(1);
        }
        return $result;
    }
}
