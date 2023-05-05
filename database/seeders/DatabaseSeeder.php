<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        //$this->call(BankStatementSeeder::class);
        //$this->call(ClientSeeder::class);
        //$this->call(CompanySeeder::class);
        //$this->call(DocumentSeeder::class);
        //$this->call(EmployeeSeeder::class);
        //$this->call(EstimateSeeder::class);
        //$this->call(EstimateItemSeeder::class);
        //$this->call(ExpenseSeeder::class);
        //$this->call(ExpenseCategorySeeder::class);
        //$this->call(FileSeeder::class);
        //$this->call(InvoiceSeeder::class);
        //$this->call(InvoiceItemSeeder::class);
        //$this->call(PropertySeeder::class);
        //$this->call(ServiceSeeder::class);
        //$this->call(TemplateSeeder::class);
        //$this->call(UserSeeder::class);


        \App\Models\User::factory()
            ->count(1)
            ->create([
            'name' => 'Test User',
            'email' => 'teko@test.com',
            'email_verified_at' => '2022-12-12 14:53:44',
            'company_id' => 1,
            'password' => \Hash::make('heslo123'),
        ]);
    }
}
