# Invoice tool based on Laravel

This project helps me to manage my customers and my invoices. 

## Only console

I use the terminal to do a lot of things, and I needed a small "invoice" tool ASAP. So naturally, I decided to create a full command-line tool to manage customers and invoices. 

## Installation

Here's how you can start using it : 

1. Create a mysql DB
2. Fill the .env to set the DB informations
3. `$ composer install` 
4. `$ php artisan migrate`

## How to use

### Create Customers

`$ php artisan customer:create`

### Create an invoice

`$ php artisan invoice:create`

You will get a prompt to chose which customer you are creating the invoice for. 

### Add a line to an invoice

`$ php artisan line:add {invoice-id}`

### See an invoice

This will show the invoice in the console

`$ php artisan invoice:show {invoice-id}` 

### Export the invoice to PDF

You will find your PDF at `./public/printed/xxxxx.pdf`