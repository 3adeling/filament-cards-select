@php
    use Filament\Support\Enums\GridDirection;
    use Illuminate\View\ComponentAttributeBag;

    $fieldWrapperView = $getFieldWrapperView();
    $extraInputAttributeBag = $getExtraInputAttributeBag();
    $gridDirection = $getGridDirection() ?? GridDirection::Column;
    $id = $getId();
    $isDisabled = $isDisabled();
    $isInline = $isInline();
    $isMultiple = $isMultiple();
    $statePath = $getStatePath();
    $wireModelAttribute = $applyStateBindingModifiers('wire:model');
@endphp

<x-dynamic-component :component="$fieldWrapperView" :field="$field">
    <div
        {{
            $getExtraAttributeBag()
                ->class([
                    'fi-fo-card-radio grid grid-cols-1 gap-4',
                    'sm:grid-cols-2' => ($cols = $getColumns()) === 2,
                    'sm:grid-cols-3' => $cols === 3 || $cols === null,
                    'sm:grid-cols-4' => $cols === 4,
                    'sm:grid-cols-5' => $cols === 5,
                    'sm:grid-cols-6' => $cols === 6,
                    'fi-inline flex flex-wrap' => $isInline,
                ])
        }}
    >
        @foreach ($getOptions() as $value => $label)
            @php
                $inputAttributes = $extraInputAttributeBag
                    ->merge([
                        'disabled' => $isDisabled || $isOptionDisabled($value, $label),
                        'id' => $id . '-' . $value,
                        'name' => $isMultiple ? null : $id,
                        'value' => $value,
                        $wireModelAttribute => $statePath,
                    ], escape: false);
            @endphp

            <label
                class="fi-fo-card-radio-option group relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm transition-all
                    has-[:disabled]:cursor-not-allowed has-[:disabled]:border-gray-200 has-[:disabled]:bg-gray-50 has-[:disabled]:opacity-50
                    has-[:checked]:border-transparent has-[:checked]:outline has-[:checked]:outline-2 has-[:checked]:-outline-offset-2 has-[:checked]:outline-primary-600
                    has-[:focus-visible]:outline has-[:focus-visible]:outline-[3px] has-[:focus-visible]:-outline-offset-1 has-[:focus-visible]:outline-primary-600
                    dark:border-white/10 dark:bg-white/5 dark:has-[:disabled]:bg-white/5 dark:has-[:checked]:outline-primary-500"
            >
                <input
                    type="{{ $isMultiple ? 'checkbox' : 'radio' }}"
                    {{
                        $inputAttributes->class([
                            'sr-only',
                        ])
                    }}
                />

                <div class="flex flex-1">
                    <div class="flex flex-col">
                        <span class="fi-fo-card-radio-option-label block text-sm font-medium text-gray-900 dark:text-white">
                            {{ $label }}
                        </span>

                        @if ($hasDescription($value))
                            <span class="fi-fo-card-radio-option-description mt-1 block text-sm text-gray-500 dark:text-gray-400">
                                {{ $getDescription($value) }}
                            </span>
                        @endif
                    </div>
                </div>

                <svg
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    class="fi-fo-card-radio-option-icon invisible size-5 shrink-0 text-primary-600 group-has-[:checked]:visible dark:text-primary-500"
                >
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                    />
                </svg>
            </label>
        @endforeach
    </div>
</x-dynamic-component>
