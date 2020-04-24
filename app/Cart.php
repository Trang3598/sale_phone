<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $discount = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->discount = $oldCart->discount;
        }
    }
    public function add($item, $id)
    {
        if ($item->start_promotion <= Carbon::now() && Carbon::now() <= $item->end_promotion) {
            $cart = ['qty' => 0, 'price' => $item->price, 'item' => $item, 'discount' => ($item->price - $item->promotion_price)];
        } else {
            $cart = ['qty' => 0, 'price' => $item->price, 'item' => $item, 'discount' => 0];
        }
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $cart = $this->items[$id];
            }
        }
        $cart['qty']++;
        $cart['price'] = $item->price * $cart['qty'];
        $this->items[$id] = $cart;
        $this->totalQty++;
        $this->totalPrice += $item->price;
    }

    public function removeItem($id)
    {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }
}
