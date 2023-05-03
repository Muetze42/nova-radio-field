# Laravel Nova Radio Buttons Field

A Radio Buttons field for [Laravel Nova](https://nova.laravel.com/).

[![Documentation](https://raw.githubusercontent.com/Muetze42/Muetze42/main/files/btn-documentation.jpg)](#install)
[![Live Preview](https://raw.githubusercontent.com/Muetze42/Muetze42/main/files/btn-live-preview.jpg)](https://nova-demo.huth.it/resources/nova-radio-field-radios/1/edit)

![Preview 1](https://raw.githubusercontent.com/Muetze42/nova-radio-field/main/docs/preview.png)

![Preview 2](https://raw.githubusercontent.com/Muetze42/nova-radio-field/main/docs/inline.png)

![Preview 3](https://raw.githubusercontent.com/Muetze42/nova-radio-field/main/docs/grid.png)

## Install

```
composer require norman-huth/nova-radio-field
```

## Usage

```php
use NormanHuth\NovaRadioField\Radio;

//..
Radio::make(__('Radio'), 'select')
    ->options([
        'S' => __('Small'),
        'M' => __('Medium'),
        'L' => __('Large'),
    ])
```

## Advanced Usage

### Field Help Text

> If you would like to place "help" text beneath a field, you may invoke the `help` method when defining your field:

```php
Radio::make(__('Radio'), 'select')
    ->help(__('Help Text'))
```

### Help Text For Radio Label

If you would like to place "help" text beneath a radio label, you may invoke the `radioHelpTexts` method when defining your field:

```php
Radio::make(__('Radio'), 'select')
    ->radioHelpTexts([
        'S' => __('Select small size'),
        'L' => __('Select large size'),
    ])
```

### Default Value

By default, this field use the first array item as default. You can set another default value via the `default` method, which accepts a value or
callback.

```php
Radio::make(__('Radio'), 'select')
    ->default('M')
    
Radio::make(__('Radio'), 'select')
    ->default(function (NovaRequest $request) {
        return $request->user()->group_id;
    }))
```

### Inline Radio Boxes

If you would like to place the radios inline instead in columns use the `inline` method:

```php
Radio::make(__('Radio'), 'select')
    ->inline()
```

### Styling

#### Controlling Gap

if you would like change the gap between radio buttons use the `gap` method:

**Default**: 1 (0.25rem)

| Method       | Gap      |
|--------------|----------|
| `->gap(0.5)` | 0.125rem |
| `->gap(1.5)` | 0.375rem |
| `->gap(2)`   | 0.5rem   |
| `->gap(2.5)` | 0.625rem |
| `->gap(3)`   | 0.75rem  |
| `->gap(3.5)` | 0.875rem |
| `->gap(4)`   | 1rem     |
| `->gap(5)`   | 1.25rem  |
| `->gap(6)`   | 1.5rem   |
| `->gap(8)`   | 2rem     |

```php
Radio::make(__('Radio'), 'select')
    ->gap(3)
```

#### Add Classes To Field

You can add classes to the field class attribute by invoking the addClasses method when defining the field:

```php
Radio::make(__('Radio'), 'select')
    ->addClasses(['text-center']), 
```

#### Set Field Classes

You can remove default field classes and set new classes of the field class attribute by invoking the setClasses method when defining the field:

```php
Radio::make(__('Radio'), 'select')
    ->setClasses(['flex', 'flex-wrap', 'justify-between']), 
```

#### Add Styles To Field

You can add styles to the field style attribute by invoking the addStyles method when defining the field:

```php
Radio::make(__('Radio'), 'select')
    ->addStyles(['max-width' => '25rem']), 
```

#### Add Classes To Field Label's

You can add classes to the field label's class attribute by invoking the addClasses method when defining the field:

```php
Radio::make(__('Radio'), 'select')
    ->addLabelClasses(['truncate']),
```

#### Add Styles To Field Label's

You can add styles to the field label's style attribute by invoking the addStyles method when defining the field:

```php
Radio::make(__('Radio'), 'select')
    ->addLabelStyles(['max-width' => '10rem']),
```

### Example: Creating Grid Like 3rd Preview

```php
Radio::make(__('Radio'), 'select')
    ->options([
        'S' => __('Small'),
        'M' => __('Medium'),
        'L' => __('Large'),
        'E' => __('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam'),
        'G' => __('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam'),
    ])
    ->radioHelpTexts([
        'S' => __('Select small size'),
        'L' => __('Select large size'),
    ])
    ->gap(4)
    ->inline()
    ->addLabelStyles(['width' => '15rem']),
```

### Display Keys On Index & Detail Page

If you would like to display the values instead the label, you may invoke the `displayUsingValues` method when defining the field :wink: :

```php
Radio::make(__('Radio'), 'select')
    ->displayUsingValues()
```
