<?php


namespace App\Services;


use App\Expense;

class ExpenseService
{

    public function create($data, $user)
    {
//        dd($user);
        $lastExpense = Expense::where('user_id', $user)
            ->where('number', '<>', null)
            ->orderBy('created_at', 'desc')
            ->first();

        // generate Name of Expense
        if (isset($data['name'])) {
            $name = $data['name'];
        } else {
            // generate name
            if ($lastExpense) {
                // get number +1
                $number = $lastExpense->number + 1;
            } else {
                $number = 1;
            }
            $name = 'Expense ' . $number;
        }

        $expense = Expense::create([
            'name' => $name,
            'description' => $data['description'],
            'amount' => $data['amount'],
            'comment' => isset($data['comment']) ? $data['comment'] : null,
            'date' => $data['date'],
            'time' => $data['time'],
            'number' => isset($number) ? $number : null,
            'user_id' => $user
        ]);

        return $expense;
    }

    public function getData($idExpense, $user)
    {
        $expense = Expense::find($idExpense);
        if ($expense) {

            if ($expense->user_id == $user) {
                return [
                    [
                        'id' => $idExpense,
                        'name' => $expense->name,
                        'amount' => $expense->amount,
                        'description' => $expense->description,
                        'date' => $expense->date,
                        'time' => $expense->time,
                        'comment' => $expense->comment,
                    ], 200];
            } else {
                return [['error' => 'Not Authorizate'], 403];
            }

        } else {
            return [['error' => 'Not Found'], 404];
        }

    }

    public function updateData($allData, $expense)
    {
        // get model attributes
        $attributes = $expense->only([
            'name', 'description', 'date', 'time', 'amount', 'comment'
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