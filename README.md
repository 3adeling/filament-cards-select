# Filament Cards Select

Card-style radio and checkbox list components for Filament v4.

## Installation

You can install the package via composer:

```bash
composer require adelali/filament-cards-select
```

## Usage

### Basic Radio Selection

```php
use Adelali\FilamentCardsSelect\Forms\Components\CardRadio;

CardRadio::make('plan')
    ->options([
        'basic' => 'Basic Plan',
        'pro' => 'Pro Plan',
        'enterprise' => 'Enterprise Plan',
    ])
```

### With Descriptions

```php
CardRadio::make('plan')
    ->options([
        'basic' => 'Basic Plan',
        'pro' => 'Pro Plan',
        'enterprise' => 'Enterprise Plan',
    ])
    ->descriptions([
        'basic' => 'Perfect for individuals getting started',
        'pro' => 'For growing teams and businesses',
        'enterprise' => 'Custom solutions for large organizations',
    ])
```

### Multiple Selection (Checkbox List)

```php
CardRadio::make('features')
    ->multiple()
    ->options([
        'sso' => 'Single Sign-On',
        'api' => 'API Access',
        'support' => 'Priority Support',
    ])
```

Or use the alias:

```php
CardRadio::make('features')
    ->checkboxList()
    ->options([...])
```

### Boolean Selection

```php
CardRadio::make('is_active')
    ->boolean('Active', 'Inactive')
```

### Grid Columns

Control the number of columns in the grid:

```php
CardRadio::make('plan')
    ->options([...])
    ->columns(2)
```

Responsive columns with breakpoints:

```php
CardRadio::make('plan')
    ->options([...])
    ->columns([
        'default' => 1,
        'sm' => 2,
        'md' => 3,
        'lg' => 4,
    ])
```

### Inline Layout

Display options inline:

```php
CardRadio::make('plan')
    ->options([...])
    ->inline()
```

### Disabling Options

```php
CardRadio::make('plan')
    ->options([
        'basic' => 'Basic Plan',
        'pro' => 'Pro Plan',
        'enterprise' => 'Enterprise Plan',
    ])
    ->disableOptionWhen(fn (string $value): bool => $value === 'enterprise')
```

## Requirements

- PHP 8.2+
- Filament v4

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
