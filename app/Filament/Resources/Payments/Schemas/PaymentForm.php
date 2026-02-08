<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_id')
                    ->required()
                    ->numeric(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('payment_method')
                    ->required()
                    ->default('MPESA'),
                TextInput::make('transaction_reference')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('COMPLETED'),
            ]);
    }
}
