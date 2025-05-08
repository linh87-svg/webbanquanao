<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'category_id' => $row[0],
            'product_name' => $row[1],
            'product_quantities' => $row[2],
            'product_sold' => $row[3],
            'product_desc' => $row[4],
            'product_price' => $row[5],
            'price_cost' => $row[6],
            'product_images' => $row[7],
            'product_status' => $row[8],
            'product_views' => $row[9],
            'created_at'         => now(),  // Thêm thời gian hiện tại
            'updated_at'         => now()
        ]);
    }
}
