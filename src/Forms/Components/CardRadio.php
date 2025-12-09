<?php

namespace Adelali\FilamentCardsSelect\Forms\Components;

use Closure;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts;
use Filament\Forms\Components\Field;
use Filament\Schemas\Components\StateCasts\BooleanStateCast;
use Filament\Schemas\Components\StateCasts\Contracts\StateCast;
use Filament\Schemas\Components\StateCasts\OptionsArrayStateCast;
use Filament\Schemas\Components\StateCasts\OptionStateCast;
use Filament\Schemas\Concerns\HasColumns;

class CardRadio extends Field implements Contracts\CanDisableOptions, Contracts\HasNestedRecursiveValidationRules
{
    use Concerns\CanDisableOptions;
    use Concerns\CanDisableOptionsWhenSelectedInSiblingRepeaterItems;
    use Concerns\CanFixIndistinctState;
    use Concerns\HasDescriptions;
    use Concerns\HasExtraInputAttributes;
    use Concerns\HasGridDirection;
    use Concerns\HasNestedRecursiveValidationRules;
    use Concerns\HasOptions;
    use HasColumns {
        columns as baseColumns;
    }

    /**
     * @var view-string
     */
    protected string $view = 'filament-cards-select::forms.components.card-radio';

    /**
     * Set the number of columns for the grid layout.
     * When an integer is passed, it applies to all breakpoints (sets as default).
     *
     * @param  array<string, int | Closure | null> | int | Closure | null  $columns
     */
    public function columns(array|int|Closure|null $columns = 2): static
    {
        if (is_int($columns)) {
            $this->columns = [
                'default' => $columns,
            ];

            return $this;
        }

        return $this->baseColumns($columns);
    }

    protected bool|Closure $isInline = false;

    protected bool|Closure $isMultiple = false;

    public function boolean(?string $trueLabel = null, ?string $falseLabel = null): static
    {
        $this->options([
            1 => $trueLabel ?? __('filament-forms::components.radio.boolean.true'),
            0 => $falseLabel ?? __('filament-forms::components.radio.boolean.false'),
        ]);

        $this->stateCast(app(BooleanStateCast::class, ['isStoredAsInt' => true]));

        return $this;
    }

    public function inline(bool|Closure $condition = true): static
    {
        $this->isInline = $condition;

        return $this;
    }

    public function isInline(): bool
    {
        return (bool) $this->evaluate($this->isInline);
    }

    /**
     * Enable checkbox list mode (multiple selection).
     */
    public function checkboxList(bool|Closure $condition = true): static
    {
        $this->isMultiple = $condition;

        return $this;
    }

    /**
     * Alias for checkboxList() - enable multiple selection.
     */
    public function multiple(bool|Closure $condition = true): static
    {
        return $this->checkboxList($condition);
    }

    public function isMultiple(): bool
    {
        return (bool) $this->evaluate($this->isMultiple);
    }

    public function getDefaultState(): mixed
    {
        $state = parent::getDefaultState();

        if (is_bool($state)) {
            return $state ? 1 : 0;
        }

        return $state;
    }

    /**
     * @return array<StateCast>
     */
    public function getDefaultStateCasts(): array
    {
        if ($this->hasCustomStateCasts() || filled($this->getEnum())) {
            return parent::getDefaultStateCasts();
        }

        if ($this->isMultiple()) {
            return [app(OptionsArrayStateCast::class)];
        }

        return [app(OptionStateCast::class, ['isNullable' => true])];
    }

    /**
     * @return ?array<string>
     */
    public function getInValidationRuleValues(): ?array
    {
        $values = parent::getInValidationRuleValues();

        if ($values !== null) {
            return $values;
        }

        return array_keys($this->getEnabledOptions());
    }

    public function hasInValidationOnMultipleValues(): bool
    {
        return $this->isMultiple();
    }

    public function hasNullableBooleanState(): bool
    {
        return ! $this->isMultiple();
    }
}
