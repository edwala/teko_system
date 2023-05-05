<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <x-nav-dropdown title="Apps" align="right" width="48">
                        @can('view-any', App\Models\BankStatement::class)
                        <x-dropdown-link href="{{ route('bank-statements.index') }}">
                        Bank Statements
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Client::class)
                        <x-dropdown-link href="{{ route('clients.index') }}">
                        Clients
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Company::class)
                        <x-dropdown-link href="{{ route('companies.index') }}">
                        Companies
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Document::class)
                        <x-dropdown-link href="{{ route('documents.index') }}">
                        Documents
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Employee::class)
                        <x-dropdown-link href="{{ route('employees.index') }}">
                        Employees
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Estimate::class)
                        <x-dropdown-link href="{{ route('estimates.index') }}">
                        Estimates
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\EstimateItem::class)
                        <x-dropdown-link href="{{ route('estimate-items.index') }}">
                        Estimate Items
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Expense::class)
                        <x-dropdown-link href="{{ route('expenses.index') }}">
                        Expenses
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\ExpenseCategory::class)
                        <x-dropdown-link href="{{ route('expense-categories.index') }}">
                        Expense Categories
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\File::class)
                        <x-dropdown-link href="{{ route('files.index') }}">
                        Files
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Invoice::class)
                        <x-dropdown-link href="{{ route('invoices.index') }}">
                        Invoices
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\InvoiceItem::class)
                        <x-dropdown-link href="{{ route('invoice-items.index') }}">
                        Invoice Items
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Property::class)
                        <x-dropdown-link href="{{ route('properties.index') }}">
                        Properties
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Service::class)
                        <x-dropdown-link href="{{ route('services.index') }}">
                        Services
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Template::class)
                        <x-dropdown-link href="{{ route('templates.index') }}">
                        Templates
                        </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\User::class)
                        <x-dropdown-link href="{{ route('users.index') }}">
                        Users
                        </x-dropdown-link>
                        @endcan
                </x-nav-dropdown>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

                @can('view-any', App\Models\BankStatement::class)
                <x-responsive-nav-link href="{{ route('bank-statements.index') }}">
                Bank Statements
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Client::class)
                <x-responsive-nav-link href="{{ route('clients.index') }}">
                Clients
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Company::class)
                <x-responsive-nav-link href="{{ route('companies.index') }}">
                Companies
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Document::class)
                <x-responsive-nav-link href="{{ route('documents.index') }}">
                Documents
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Employee::class)
                <x-responsive-nav-link href="{{ route('employees.index') }}">
                Employees
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Estimate::class)
                <x-responsive-nav-link href="{{ route('estimates.index') }}">
                Estimates
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\EstimateItem::class)
                <x-responsive-nav-link href="{{ route('estimate-items.index') }}">
                Estimate Items
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Expense::class)
                <x-responsive-nav-link href="{{ route('expenses.index') }}">
                Expenses
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\ExpenseCategory::class)
                <x-responsive-nav-link href="{{ route('expense-categories.index') }}">
                Expense Categories
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\File::class)
                <x-responsive-nav-link href="{{ route('files.index') }}">
                Files
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Invoice::class)
                <x-responsive-nav-link href="{{ route('invoices.index') }}">
                Invoices
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\InvoiceItem::class)
                <x-responsive-nav-link href="{{ route('invoice-items.index') }}">
                Invoice Items
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Property::class)
                <x-responsive-nav-link href="{{ route('properties.index') }}">
                Properties
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Service::class)
                <x-responsive-nav-link href="{{ route('services.index') }}">
                Services
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\Template::class)
                <x-responsive-nav-link href="{{ route('templates.index') }}">
                Templates
                </x-responsive-nav-link>
                @endcan
                @can('view-any', App\Models\User::class)
                <x-responsive-nav-link href="{{ route('users.index') }}">
                Users
                </x-responsive-nav-link>
                @endcan

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="shrink-0">
                    <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>