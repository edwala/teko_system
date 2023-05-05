@php $editing = isset($invoiceItem) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="invoice_id" label="Invoice" required>
            @php $selected = old('invoice_id', ($editing ? $invoiceItem->invoice_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Invoice</option>
            @foreach($invoices as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $invoiceItem->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="item_cost"
            label="Item Cost"
            :value="old('item_cost', ($editing ? $invoiceItem->item_cost : ''))"
            max="255"
            step="0.01"
            placeholder="Item Cost"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="count"
            label="Count"
            :value="old('count', ($editing ? $invoiceItem->count : ''))"
            max="255"
            placeholder="Count"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="total_cost"
            label="Total Cost"
            :value="old('total_cost', ($editing ? $invoiceItem->total_cost : ''))"
            max="255"
            step="0.01"
            placeholder="Total Cost"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="vat"
            label="Vat"
            :value="old('vat', ($editing ? $invoiceItem->vat : ''))"
            max="255"
            step="0.01"
            placeholder="Vat"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
