<?php

namespace NormanHuth\NovaRadioField;

use JetBrains\PhpStorm\ExpectedValues;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Util;
use NormanHuth\NovaBasePackage\HasStyle;
use NormanHuth\NovaBasePackage\IsNova;

class Radio extends Select
{
    use HasStyle;
    use IsNova;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-radio-field';

    /**
     * Display values using their corresponding specified labels.
     *
     * @var bool
     */
    protected bool $displayUsingLabels = true;

    /**
     * Display radio buttons inline instead columns.
     *
     * @var bool
     */
    protected bool $radioInline = false;

    /**
     * Gutters between items.
     *
     * @var int
     */
    protected int $gap = 1;

    /**
     * @var mixed
     */
    protected mixed $radioOptions;

    /**
     * The help text for the radio buttons.
     *
     * @var array
     */
    protected array $radioHelpTexts = [];

    /**
     * The field's styles.
     *
     * @var array
     */
    protected array $styles = [];

    /**
     * The label classes.
     *
     * @var array
     */
    protected array $labelClasses = [];

    /**
     * The field label's styles.
     *
     * @var array
     */
    protected array $labelStyles = [];

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|\Closure|callable|object|null  $attribute
     * @param  (callable(mixed, mixed, ?string):(mixed))|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        $this->classes = ['{field-default-classes}'];
        $this->labelClasses = ['cursor-pointer'];
        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * Display values using their corresponding specified keys.
     *
     * @return $this
     */
    public function displayUsingValues(): static
    {
        $this->displayUsingLabels = false;

        return $this;
    }

    /**
     * Resolve the field's value for display.
     *
     * @param mixed       $resource
     * @param string|null $attribute
     * @return void
     */
    public function resolveForDisplay($resource, $attribute = null): void
    {
        if ($this->displayUsingLabels) {
            $this->displayUsingLabels();
        }

        parent::resolveForDisplay($resource, $attribute);
    }

    /**
     * Serialize options for the field.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function serializeRadioOptions(): array
    {
        return collect($this->getRadioOptions() ?? [])->map(function ($label, $value) {
            $value = Util::safeInt($value);

            return is_array($label) ? $label + ['value' => $value] : ['label' => $label, 'value' => $value];
        })->values()->all();
    }

    /**
     * Get options for the field.
     *
     * @return mixed
     */
    protected function getRadioOptions(): mixed
    {
        if (!isset($this->radioOptions)) {
            $options = value($this->optionsCallback);

            if (is_callable($options)) {
                $options = $options();
            }

            $this->radioOptions = $options;
        }

        return $this->radioOptions;
    }

    /**
     * Add help text to the radio buttons.
     *
     * @param array $array
     * @return $this
     */
    public function radioHelpTexts(array $array): static
    {
        $this->radioHelpTexts = $array;

        return $this;
    }

    /**
     * Add classes to the field label's class attributes.
     *
     * @param string|array $classes
     * @return $this
     */
    public function addLabelClasses(string|array $classes): static
    {
        $this->labelClasses = array_merge($this->labelClasses, (array) $classes);

        return $this;
    }

    /**
     * Set classes to the field label's class attributes.
     *
     * @param string|array $classes
     * @return $this
     */
    public function setLabelClasses(string|array $classes): static
    {
        $this->labelClasses = (array) $classes;

        return $this;
    }

    /**
     * Add styles to the field label's style attributes.
     *
     * @param array $styles
     * @return $this
     */
    public function addLabelStyles(array $styles): static
    {
        $this->labelStyles = array_merge($this->labelStyles, $styles);

        return $this;
    }

    /**
     * Controlling gutters between radio buttons.
     *
     * @param float $gap
     * @return $this
     */
    public function gap(
        #[ExpectedValues(values: [0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 5, 6, 8])]
        float $gap
    ): static
    {
        $this->gap = $gap;

        return $this;
    }

    /**
     * Determine if radio buttons displaying inline instead columns.
     *
     * @return $this
     */
    public function inline(): static
    {
        $this->radioInline = true;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        if ($this->isFormRequest()) {
            $this->resolveValue();
            $this->resolveClasses();
        }

        $this->withMeta([
            'options' => $this->serializeRadioOptions(),
            'radioHelps' => $this->radioHelpTexts,
            'classes' => $this->classes,
            'labelClasses' => $this->labelClasses,
            'styles' => $this->styles,
            'labelStyles' => $this->labelStyles,
        ]);

        return Field::jsonSerialize();
    }

    protected function resolveClasses(): void
    {
        $this->classes = array_map(function ($item) {
            $classes = $this->radioInline ? 'inline-flex flex-wrap' : 'flex flex-col';
            $classes .= ' gap-'.$this->gap;

            return str_replace('{field-default-classes}', $classes, trim($item));
        }, $this->classes);
    }

    /**
     * Resolve Value on Forms.
     *
     * @return void
     */
    protected function resolveValue(): void
    {
        $options = $this->getRadioOptions();

        if (isset($options[$this->value]) || empty($options)) {
            return;
        }

        $defaultValue = $this->resolveDefaultValue($this->getRequest());

        if (class_exists('\Laravel\Nova\Support\UndefinedValue') &&
            $defaultValue instanceof \Laravel\Nova\Support\UndefinedValue) {
            $defaultValue = null;
        }

        if ($defaultValue && isset($options[$defaultValue])) {
            $this->value = $defaultValue;
            return;
        }

        $this->value = array_key_first($options);
    }
}
