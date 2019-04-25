<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\GetExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    //
    protected $expenseService;

    public function __construct()
    {
        $this->expenseService = new ExpenseService();
    }

    public function getList(Request $request)
    {
        // todo: ver si se va a mostrar con un datatable


    }

//    public function filter(Request $request)
//    {
//    }

    public function create(CreateExpenseRequest $request)
    {
        // create the expense
        $user = Auth::user()->id;
        $expense = $this->expenseService->create($request->all(), $user);

        return response()->json([
            'success' => true,
            'expense' => $expense
        ]);
    }

    public function getData(GetExpenseRequest $request, $idExpense)
    {
        $expense = $this->expenseService->getData($idExpense);

        return response()->json([
            'success' => true,
            'expense' => $expense
        ]);
    }


    public function edit(UpdateExpenseRequest $request)
    {
        $idExpense = $request->input('expense');
        $expense = Expense::find($idExpense);

        $expense = $this->expenseService->updateData($request->all(), $expense);

        return response()->json([
            'success' => true,
            'expense' => $expense
        ]);

    }

    public function remove(Request $request)
    {
        $idExpense = $request->input('expense');
        $expense = Expense::find($idExpense);

        // remove expense
        $expense->delete();
        return response()->json([
            'success' => true,
        ]);
    }


}
