<?php


namespace App\Repositories;


class ProductRepository extends Repository
{
    public function searchDetail($data)
    {
        $products = $this->model->newQuery();
        if (isset($data['price_from'])) {
            $products->where('price', '>=', $data['price_from']);
        }
        if (isset($data['price_to'])) {
            $products->where('price', '<=', $data['price_to']);
        }
        if (isset($data['showList'])) {
            if ($data['showList'] == self::HOT) {
                $products->where('sale_phone', '=', 1);
            } elseif ($data['showList'] == self::HIGHT_TO_LOW) {
                $products->orderByRaw('price DESC');
            } elseif ($data['showList'] == self::LOW_TO_HIGHT) {
                $products->orderByRaw('price ASC');
            } elseif ($data['showList'] == self::ALL) {
                $products->select();
            }
        }
        return $products;
    }

    public function listNewProduct($param)
    {
        $products = $this->model->orderBy($param, 'desc')->paginate(12);
        return $products;
    }
}
