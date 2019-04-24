<?php

namespace App\Http\Controllers;

use App\Expense;
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

    public function filter(Request $request)
    {
        // todo: por hacer
    }

    public function create(Request $request)
    {
        // required -> name, lastname, email , phone number
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'amount' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i:s',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // create the expense
        $user = Auth::user()->id;
        $expense = $this->expenseService->create($request->all(), $user);

        return response()->json([
            'success' => true,
            'expense' => $expense
        ]);
    }

    public function getData(Request $request, $idExpense)
    {

        $user = Auth::user()->id;
        list($expense, $code) = $this->expenseService->getData($idExpense, $user);

        if ($code == 200) {
            return response()->json([
                'success' => true,
                'expense' => $expense
            ]);
        } else {
            return response()->json($expense, $code);
        }
    }


    public function edit(Request $request)
    {
        $idExpense = $request->input('expense');
        $user = Auth::user()->id;

        $expense = Expense::find($idExpense);
        if ($expense) {

            if ($expense->user_id == $user) {

                $validator = Validator::make($request->all(), [
                    'description' => 'required',
                    'amount' => 'required|integer',
                    'date' => 'required|date_format:Y-m-d',
                    'time' => 'required|date_format:H:i:s',
                    'comment' => 'required'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ]);
                }

                $expense = $this->expenseService->updateData($request->all(), $expense);

                return response()->json([
                    'success' => true,
                    'expense' => $expense
                ]);

            } else {
                // not is your expense
                return response()->json(['error' => 'Not Authorizate'], 403);
            }

        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }

    public function remove(Request $request)
    {
        $idExpense = $request->input('expense');
        $expense = Expense::find($idExpense);
        if ($expense) {

            // remove expense
            $expense->delete();
            return response()->json([
                'success' => true,
            ]);

        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }


}
