## Generate secret key - JWT
`php artisan jwt:secret`

## Features Test
Add ".\vendor\bin" to PATH
`composer test`
or
`.\vendor\bin\phpunit`

## EndPoint API
**POST**    **api/login**       Login App
**POST**    **api/regsiter**    Register User
**POST**    **api/logout**     _todo_

**POST**    **api/profile/edit**     Edit data of user

**POST**    **api/expenses/list**           _todo_: Waiting for seeing how i will show the data
**GET**    **api/expense/details/{id}**     _id_: ExpenseID 
**POST**    **api/expense/create**          Create expense
**POST**    **api/expense/edit**            Update expense
**POST**    **api/expense/remove**          Remove expense
