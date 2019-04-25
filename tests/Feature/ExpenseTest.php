<?php

namespace Tests\Feature;

use App\Expense;
use App\Services\ExpenseService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExpenseTest extends TestCase
{

    use RefreshDatabase;

    protected $user;
    protected $expenseService;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->expenseService = new ExpenseService();
        parent::__construct($name, $data, $dataName);
    }

    private function authenticate()
    {
        $user = User::create([
            'name' => 'User',
            'lastname' => 'Test',
            'email' => 'test@domain.com',
            'phone' => '54830917',
            'password' => bcrypt('asdasd'),
        ]);
        $this->user = $user;
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    public function testCreate()
    {
        // Get JWT token
        $token = $this->authenticate();

        $data = [
            'description' => 'Carro',
            'amount' => '150',
            'date' => '2019-04-25',
            'time' => '20:00:00',
            'comment' => 'Renta mensual',
        ];

        // append Token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', route('expense.create'), $data);

        $response->assertStatus(200);
        $this->assertArraySubset(['success' => true], $response->json());

    }

    public function testGetData()
    {
        // Get JWT token
        $token = $this->authenticate();

        $data = [
            'description' => 'Carro',
            'amount' => '150',
            'date' => '2019-04-25',
            'time' => '20:00:00',
            'comment' => 'Renta mensual',
        ];

        $expense = $this->expenseService->create($data, $this->user->id);

        // append Token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', route('expense.details', ['id' => $expense->id]));

        $response->assertStatus(200);
        $this->assertArraySubset(['success' => true], $response->json());


    }

    public function testEdit()
    {
        // Get JWT token
        $token = $this->authenticate();

        $data = [
            'description' => 'New Expense',
            'amount' => '150',
            'date' => '2019-04-25',
            'time' => '20:00:00',
            'comment' => 'Renta mensual',
        ];

        $expense = $this->expenseService->create($data, $this->user->id);

        // update data for request
        $data['expense'] = $expense->id;
        $data['description'] = 'NewName';

        // append Token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', route('expense.edit', $data));

        $response->assertStatus(200);
        $responseArray = $response->json();

        $this->assertArraySubset(['success' => true], $responseArray);

        $this->assertTrue(($responseArray['expense']['description'] == 'NewName'));
    }

    public function testRemove()
    {
        // Get JWT token
        $token = $this->authenticate();

        $data = [
            'description' => 'New Expense',
            'amount' => '150',
            'date' => '2019-04-25',
            'time' => '20:00:00',
            'comment' => 'Renta mensual',
        ];

        $expense = $this->expenseService->create($data, $this->user->id);

        // append Token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', route('expense.remove', ['expense' => $expense->id]));

        $this->assertArraySubset(['success' => true], $response->json());

        // find Expense created
        $existExpense = Expense::find($expense->id);
        $this->assertNull($existExpense);

    }


}
