<?php

namespace NormanHuth\NovaRadioField;

use JetBrains\PhpStorm\ExpectedValues;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Util;

class Radio extends Select
{
    /**
     * The field's component.
     *
     * @var string
     */
    protected string $formComponent = 'nova-radio-field';

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
    protected bool $inline = false;

    /**
     * Gutters between items.
     *
     * @var int
     */
    protected int $gap = 1;

    /**
     * @var bool
     */
    protected bool $isEditing;

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
     * Get the component name for the field.
     *
     * @return string
     */
    public function component(): string
    {
        if ($this->isEditing()) {
            return $this->formComponent;
        }

        return parent::component();
    }

    /**
     * Determine if this request is a editing request.
     *
     * @return bool
     */
    protected function isEditing(): bool
    {
        if (!isset($this->isEditing)) {
            $request = app(NovaRequest::class);
            $editing = $request->input('editing');

            $this->isEditing = in_array($editing, ['true', true]);
        }

        return $this->isEditing;
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
     * @param  mixed  $resource
     * @param  string|null  $attribute
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
     * Controlling gutters between radio buttons.
     *
     * @param float $gap
     * @return $this
     */
    public function gap(
        #[ExpectedValues(values: [0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 5, 6, 8])]
        float $gap
    ): static {
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
        $this->inline = true;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        if ($this->isEditing()) {
            $options = $this->getRadioOptions();

            if (!isset($options[$this->value]) && !empty($options)) {
                $this->value = array_key_first($options);
            }
        }

        $containerClasses = $this->inline ? 'gap-x-' : 'flex-col gap-y-';
        $containerClasses.= $this->gap;

        $this->withMeta([
            'options'    => $this->serializeRadioOptions(),
            'radioHelps' => $this->radioHelpTexts,
            'cClasses'    => $containerClasses,
        ]);

        return Field::jsonSerialize();
    }
}
