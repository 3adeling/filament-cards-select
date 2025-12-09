@php
    use Filament\Support\Enums\GridDirection;

    $fieldWrapperView = $getFieldWrapperView();
    $extraInputAttributeBag = $getExtraInputAttributeBag();
    $gridDirection = $getGridDirection() ?? GridDirection::Column;
    $id = $getId();
    $isDisabled = $isDisabled();
    $isInline = $isInline();
    $isMultiple = $isMultiple();
    $statePath = $getStatePath();
    $wireModelAttribute = $applyStateBindingModifiers('wire:model');

    $columns = $getColumns();

    // Handle both integer and array column configurations
    if (is_int($columns)) {
        $defaultCols = $columns;
        $smCols = null;
        $mdCols = null;
        $lgCols = null;
        $xlCols = null;
        $xxlCols = null;
    } else {
        $defaultCols = $columns['default'] ?? 1;
        $smCols = $columns['sm'] ?? null;
        $mdCols = $columns['md'] ?? null;
        $lgCols = $columns['lg'] ?? null;
        $xlCols = $columns['xl'] ?? null;
        $xxlCols = $columns['2xl'] ?? null;
    }
@endphp

<x-dynamic-component :component="$fieldWrapperView" :field="$field">
    <div
        @if ($isInline)
            {{
                $getExtraAttributeBag()
                    ->class([
                        'fi-fo-card-radio fi-inline flex flex-wrap gap-4',
                    ])
            }}
        @else
            {{
                $getExtraAttributeBag()
                    ->class([
                        'fi-fo-card-radio grid gap-4',
                        match ($defaultCols) {
                            1 => 'grid-cols-1',
                            2 => 'grid-cols-2',
                            3 => 'grid-cols-3',
                            4 => 'grid-cols-4',
                            5 => 'grid-cols-5',
                            6 => 'grid-cols-6',
                            default => 'grid-cols-1',
                        },
                        match ($smCols) {
                            1 => 'sm:grid-cols-1',
                            2 => 'sm:grid-cols-2',
                            3 => 'sm:grid-cols-3',
                            4 => 'sm:grid-cols-4',
                            5 => 'sm:grid-cols-5',
                            6 => 'sm:grid-cols-6',
                            default => null,
                        },
                        match ($mdCols) {
                            1 => 'md:grid-cols-1',
                            2 => 'md:grid-cols-2',
                            3 => 'md:grid-cols-3',
                            4 => 'md:grid-cols-4',
                            5 => 'md:grid-cols-5',
                            6 => 'md:grid-cols-6',
                            default => null,
                        },
                        match ($lgCols) {
                            1 => 'lg:grid-cols-1',
                            2 => 'lg:grid-cols-2',
                            3 => 'lg:grid-cols-3',
                            4 => 'lg:grid-cols-4',
                            5 => 'lg:grid-cols-5',
                            6 => 'lg:grid-cols-6',
                            default => null,
                        },
                        match ($xlCols) {
                            1 => 'xl:grid-cols-1',
                            2 => 'xl:grid-cols-2',
                            3 => 'xl:grid-cols-3',
                            4 => 'xl:grid-cols-4',
                            5 => 'xl:grid-cols-5',
                            6 => 'xl:grid-cols-6',
                            default => null,
                        },
                        match ($xxlCols) {
                            1 => '2xl:grid-cols-1',
                            2 => '2xl:grid-cols-2',
                            3 => '2xl:grid-cols-3',
                            4 => '2xl:grid-cols-4',
                            5 => '2xl:grid-cols-5',
                            6 => '2xl:grid-cols-6',
                            default => null,
                        },
                    ])
            }}
        @endif
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
