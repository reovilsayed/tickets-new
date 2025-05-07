<?php

namespace App\Models\Traits;

use App\Models\Transaction;

trait HasWallet
{
    public function deposit($amount)
    {
        $this->balance += $amount;
        $this->save();
        return  $this->createTranscation($amount, 'debit', 'Deposit', 'balance_deposit');
    }

    public function spend($amount, $description = null)
    {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->save();
            return  $this->createTranscation($amount, 'credit', $description ?: 'Balance spent on goods or service', 'balance_spent');
        } else {
            throw new \Exception("Insufficient balance.");
        }
    }
    public function refund($amount)
    {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->save();
            return    $this->createTranscation($amount, 'debit', 'Refund', 'balance_refund');
        } else {
            throw new \Exception("Insufficient balance.");
        }
    }

    protected function createTranscation($amount, $type, $description, $key)
    {
        return $this->transactions()->create([
            'amount' => $amount,
            'type' => $type,
            'key' => $key,
            'description' => $description,
        ]);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionalbe');
    }
}
