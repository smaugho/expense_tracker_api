<?php


namespace App\Services;


use App\Expense;

class ExpenseService
{

    public function create($data, $user)
    {
        $lastExpense = Expense::where('user_id', $user)
            ->where('number', '<>', null)
            ->orderBy('created_at', 'desc')
            ->first();

        // generate Name of Expense
        if (isset($data['description'])) {
            $description = $data['description'];
        } else {
            // generate name
            if ($lastExpense) {
                // get number +1
                $number = $lastExpense->number + 1;
            } else {
                $number = 1;
            }
            $description = 'Expense ' . $number;
        }

        $expense = Expense::create([
            'description' => $description,
            'amount' => $data['amount'],
            'comment' => isset($data['comment']) ? $data['comment'] : null,
            'date' => $data['date'],
            'time' => $data['time'],
            'number' => isset($number) ? $number : null,
            'user_id' => $user
        ]);

        return $expense;
    }

    public function getData($idExpense)
    {
        $expense = Expense::find($idExpense);
        if ($expense) {
            return [
                'id' => $idExpense,
                'amount' => $expense->amount,
                'description' => $expense->description,
                'date' => $expense->date,
                'time' => $expense->time,
                'comment' => $expense->comment,
            ];
        } else {
            return false;
        }
    }

    public function updateData($allData, $expense)
    {
        // get model attributes
        $attributes = $expense->only([
            'description', 'date', 'time', 'amount', 'comment'
        ]);

        // update data in the model
        foreach ($allData as $key => $data) {
            if (array_key_exists($key, $attributes))
                $expense->setAttribute($key, $data);
        }
        $expense->save();

        return $expense;
    }
}