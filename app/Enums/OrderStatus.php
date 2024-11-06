<?php

namespace App\Enums;

enum OrderStatus:string{
    case Unpaid = 'unpaid';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Canceled = 'canceled';
    case Completed = 'completed';

    public static function getStatuses(){
        return [
            self::Paid, self::Unpaid, self::Canceled, self::Shipped, self::Completed
        ];
    }
}

?>
