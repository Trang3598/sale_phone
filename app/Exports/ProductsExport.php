<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            "id",
            "Category_ID",
            "Phone Name",
            "Title",
            "Description",
            "Quantity",
            "Detail",
            "Price",
            "Size",
            "Memory",
            "Weight",
            "CPU Speed",
            "RAM",
            "Operating System",
            "Camera Primary",
            "Battery",
            "Warranty",
            "Bluetooth",
            "Wlan",
            "Promotion Price",
            "Date Start Promotion",
            "Date End Promotion",
            "Sale Phone",
            "Created At",
            "Updated At "];
    }
}
