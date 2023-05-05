

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div {{ $attributes->merge($getExtraAttributes())->class(['filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group']) }}>
        <div class="flex-1">
            <input
                    x-data="textInputFormComponent({
                        null }}
                        state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')', lazilyEntangledModifiers: ['defer']) }},
                    })"
                    type="text"
                    wire:ignore
                    {!! $isLazy() ? "x-on:blur=\"\$wire.\$refresh\"" : null !!}
                    {!! $isDebounced() ? "x-on:input.debounce.{$getDebounce()}=\"\$wire.\$refresh\"" : null !!}


                dusk="filament.forms.{{ $getStatePath() }}"




                x-bind:class="{
                    'border-gray-300': ! (@js($getStatePath()) in $wire.__instance.serverMemo.errors),
                    'dark:border-gray-600': ! (@js($getStatePath()) in $wire.__instance.serverMemo.errors) && @js(config('forms.dark_mode')),
                    'border-danger-600 ring-danger-600': (@js($getStatePath()) in $wire.__instance.serverMemo.errors),
                    'dark:border-danger-400 dark:ring-danger-400': (@js($getStatePath()) in $wire.__instance.serverMemo.errors) && @js(config('forms.dark_mode')),
                }"
            />
        </div>


    </div>


</x-dynamic-component>
