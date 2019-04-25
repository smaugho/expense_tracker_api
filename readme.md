## Generate secret key - JWT

`php artisan jwt:secret`

## Features Test

Add ".\vendor\bin" to PATH  
`composer test`  
or  
`.\vendor\bin\phpunit`

## EndPoint API

**POST** &nbsp; &nbsp; **api/login** &nbsp; &nbsp; Login App  
**POST** &nbsp; &nbsp; **api/regsiter** &nbsp; &nbsp; Register User  
**POST** &nbsp; &nbsp; **api/logout** &nbsp; &nbsp; _todo_

**POST** &nbsp; &nbsp; **api/profile/edit** &nbsp; &nbsp; Edit data of user

**POST** &nbsp; &nbsp; **api/expenses/list** &nbsp; &nbsp; _todo_: Waiting for seeing how i will show the data  
**GET** &nbsp; &nbsp; **api/expense/details/{id}** &nbsp; &nbsp; _id_: ExpenseID  
**POST** &nbsp; &nbsp; **api/expense/create** &nbsp; &nbsp; Create expense  
**POST** &nbsp; &nbsp; **api/expense/edit** &nbsp; &nbsp; Update expense  
**POST** &nbsp; &nbsp; **api/expense/remove** &nbsp; &nbsp; Remove expense
