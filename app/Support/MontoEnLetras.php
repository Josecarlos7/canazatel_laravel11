<?php

namespace App\Support;

use Luecano\NumeroALetras\NumeroALetras;

class MontoEnLetras
{
    public static function bolivianos(float|int|string $monto): string
    {
        $formatter = new NumeroALetras();
        $formatter->conector = 'CON';

        return trim($formatter->toInvoice((float) $monto, 2, 'BOLIVIANOS'));
    }
}
