<?php

namespace App\Http\Requests;

use App\Expense;
use Illuminate\Foundation\Http\FormRequest;

class RemoveExpense extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $idExpense = $this->input('expense');
        $expense = Expense::find($idExpense);

        return $expense && $this->user()->id == $expense->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'expense' => 'required',
        ];
    }
}
