@php $editing = isset($client) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="company_id" label="Company" required>
            @php $selected = old('company_id', ($editing ? $client->company_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Company</option>
            @foreach($companies as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="company_name"
            label="Company Name"
            :value="old('company_name', ($editing ? $client->company_name : ''))"
            maxlength="255"
            placeholder="Company Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="billing_address"
            label="Billing Address"
            :value="old('billing_address', ($editing ? $client->billing_address : ''))"
            maxlength="255"
            placeholder="Billing Address"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="tax_id"
            label="Tax Id"
            :value="old('tax_id', ($editing ? $client->tax_id : ''))"
            maxlength="255"
            placeholder="Tax Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="vat_id"
            label="Vat Id"
            :value="old('vat_id', ($editing ? $client->vat_id : ''))"
            maxlength="255"
            placeholder="Vat Id"
        ></x-inputs.text>
    </x-inputs.group>
</div>
