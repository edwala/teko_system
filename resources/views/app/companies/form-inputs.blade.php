@php $editing = isset($company) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="uuid"
            label="Uuid"
            :value="old('uuid', ($editing ? $company->uuid : ''))"
            maxlength="255"
            placeholder="Uuid"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="company_name"
            label="Company Name"
            :value="old('company_name', ($editing ? $company->company_name : ''))"
            maxlength="255"
            placeholder="Company Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="billing_address"
            label="Billing Address"
            :value="old('billing_address', ($editing ? $company->billing_address : ''))"
            maxlength="255"
            placeholder="Billing Address"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="tax_id"
            label="Tax Id"
            :value="old('tax_id', ($editing ? $company->tax_id : ''))"
            maxlength="255"
            placeholder="Tax Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="vat_id"
            label="Vat Id"
            :value="old('vat_id', ($editing ? $company->vat_id : ''))"
            maxlength="255"
            placeholder="Vat Id"
        ></x-inputs.text>
    </x-inputs.group>
</div>
