<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderSuccess extends Controller
{
    // Success page
    public function index($name, $surname, $email, $cell, $address, $suburb, $items, 
    $total, $trackid, $coupon, $delivery_date, $date, $month, $occasion)
    {
        $data = [
            'title'     => 'Order Success',
            'name'      => $name ?? 'Null',
            'surname'   => $surname ?? 'Null',
            'email'     => $email ?? '',
            'cell'      => $cell ?? 'Null',
            'address'   => $address ?? 'Null',
            'suburb'    => $suburb ?? 'Null',
            'items'     => $items ?? 'Null',
            'total'     => $total ?? 'Null',
            'trackid'   => $trackid ?? 'Null',
            'coupon'    => $coupon ?? 'Null',
            'delivery_date' => $delivery_date ?? 'Null',
            'date'      => $date ?? 'Null',
            'month'     => $month ?? 'Null',
            'occasion'  => $occasion ?? 'Null'
        ];
        return view('success')->with($data);
    }
}
