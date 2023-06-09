<x-filament-companies::grid-section class="mt-8">
    <x-slot name="title">
        {{ __('filament-companies::default.grid_section_titles.company_name') }}
    </x-slot>

    <x-slot name="description">
        {{ __('filament-companies::default.grid_section_descriptions.company_name') }}
    </x-slot>

    <form wire:submit.prevent="updateCompanyName" class="col-span-2 mt-5 sm:col-span-1 md:mt-0">
        <x-filament::card>
            <!-- Company Owner Information -->
            <div class="col-span-6">
                <x-filament-companies::label value="{{ __('filament-companies::default.labels.company_owner') }}" />

                <div class="mt-4 flex items-center">
                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $company->owner->profile_photo_url }}"
                        alt="{{ $company->owner->name }}">

                    <div class="ml-4 leading-tight">
                        <div class="dark:text-white">{{ $company->owner->name }}</div>
                        <div class="text-sm text-gray-700 dark:text-gray-300">{{ $company->owner->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Company Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-forms::field-wrapper id="name" statePath="name" required="true" label="{{ __('filament-companies::default.labels.company_name') }}">

                <x-filament-companies::input id="name" type="text"
                    wire:model.defer="state.name" :disabled="!Gate::check('update', $company)" />


                </x-forms::field-wrapper>

            </div>

            <div class="col-span-6 sm:col-span-4">


                <x-forms::field-wrapper id="billing_address" statePath="billing_address" required="true" label="{{ __('Fakturační adresa') }}">

                    <x-filament-companies::input id="billing_address" type="text"
                                                 wire:model.defer="state.billing_address" :disabled="!Gate::check('update', $company)" />

                </x-forms::field-wrapper>



            </div>

            <div class="col-span-6 sm:col-span-4">


                <x-forms::field-wrapper id="tax_id" statePath="tax_id" required="true" label="{{ __('IČO') }}">

                    <x-filament-companies::input id="tax_id" type="text"
                                                 wire:model.defer="state.tax_id" :disabled="!Gate::check('update', $company)" />

                </x-forms::field-wrapper>



            </div>


            <div class="col-span-6 sm:col-span-4">


                <x-forms::field-wrapper id="vat_id" statePath="vat_id" required="true" label="{{ __('DIČ') }}">

                    <x-filament-companies::input id="vat_id" type="text"
                                                 wire:model.defer="state.vat_id" :disabled="!Gate::check('update', $company)" />

                </x-forms::field-wrapper>



            </div>


            <div class="col-span-6 sm:col-span-4">


                <x-forms::field-wrapper id="account" statePath="account" required="true" label="{{ __('Bank account') }}">

                    <x-filament-companies::input id="account" type="text"
                                                 wire:model.defer="state.account" :disabled="!Gate::check('update', $company)" />

                </x-forms::field-wrapper>



            </div>

            <div class="col-span-6 sm:col-span-4">


                <x-forms::field-wrapper id="back_code" statePath="back_code" required="true" label="{{ __('Bank Code') }}">

                    <x-filament-companies::input id="back_code" type="text"
                                                 wire:model.defer="state.back_code" :disabled="!Gate::check('update', $company)" />

                </x-forms::field-wrapper>

            </div>



            @if (Gate::check('update', $company))
                <x-slot name="footer">
                    <div class="text-left">
                        <x-filament::button type="submit">
                            {{ __('filament-companies::default.buttons.save') }}
                        </x-filament::button>
                    </div>
                </x-slot>
            @endif
        </x-filament::card>
    </form>
</x-filament-companies::grid-section>
