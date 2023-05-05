@php $editing = isset($file) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="document_id" label="Document" required>
            @php $selected = old('document_id', ($editing ? $file->document_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Document</option>
            @foreach($documents as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="is_active"
            label="Is Active"
            :checked="old('is_active', ($editing ? $file->is_active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.partials.label
            name="file"
            label="File"
        ></x-inputs.partials.label
        ><br />

        <input type="file" name="file" id="file" class="form-control-file" />

        @if($editing && $file->file)
        <div class="mt-2">
            <a href="{{ \Storage::url($file->file) }}" target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('file') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>
</div>
