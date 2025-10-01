<?php

namespace App\Services;

use Illuminate\Support\HtmlString;

class CmsFormBuilder
{
    /**
     * Render form fields based on schema
     */
    public function renderFields(array $schema, array $data = [], string $prefix = ''): string
    {
        $html = '';

        foreach ($schema as $fieldName => $fieldConfig) {
            $fieldId = $prefix ? "{$prefix}[{$fieldName}]" : $fieldName;
            $fieldValue = data_get($data, $fieldName);
            $html .= $this->renderField($fieldName, $fieldConfig, $fieldValue, $fieldId);
        }

        return $html;
    }

    /**
     * Render a single field
     */
    private function renderField(string $name, array $config, $value, string $fieldId): string
    {
        $type = $config['type'] ?? 'text';
        $label = $config['label'] ?? ucfirst($name);
        $required = $config['required'] ?? false;
        $placeholder = $config['placeholder'] ?? '';
        $help = $config['help'] ?? '';

        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        $errorClass = ''; // We'll handle errors in the controller

        $html = "<div class=\"col-md-{$this->getFieldColSize($config)}\ mb-3\">";
        $html .= "<label for=\"{$fieldId}\" class=\"form-label\">{$label} {$requiredMark}</label>";

        switch ($type) {
            case 'text':
            case 'email':
            case 'url':
            case 'number':
                $html .= $this->renderInputField($type, $fieldId, $value, $config, $errorClass);
                break;

            case 'textarea':
                $html .= $this->renderTextareaField($fieldId, $value, $config, $errorClass);
                break;

            case 'richtext':
                $html .= $this->renderRichtextField($fieldId, $value, $config, $errorClass);
                break;

            case 'select':
                $html .= $this->renderSelectField($fieldId, $value, $config, $errorClass);
                break;

            case 'checkbox':
                $html .= $this->renderCheckboxField($fieldId, $value, $config);
                break;

            case 'date':
            case 'time':
                $html .= $this->renderDateTimeField($type, $fieldId, $value, $config, $errorClass);
                break;

            case 'image':
                $html .= $this->renderImageField($fieldId, $value, $config, $errorClass);
                break;

            case 'group':
                $html .= $this->renderGroupField($name, $config, $value, $fieldId);
                break;

            case 'repeater':
                $html .= $this->renderRepeaterField($name, $config, $value, $fieldId);
                break;
        }

        if ($help) {
            $html .= "<small class=\"form-text text-muted\">{$help}</small>";
        }

        $html .= "</div>";

        return $html;
    }

    /**
     * Get field column size
     */
    private function getFieldColSize(array $config): int
    {
        return $config['col_size'] ?? 12;
    }

    /**
     * Render input field
     */
    private function renderInputField(string $type, string $fieldId, $value, array $config, string $errorClass): string
    {
        $attributes = $this->buildAttributes($config, ['type' => $type, 'id' => $fieldId, 'name' => $fieldId, 'value' => $value, 'class' => "form-control {$errorClass}"]);

        return "<input " . $this->attributesToString($attributes) . ">";
    }

    /**
     * Render textarea field
     */
    private function renderTextareaField(string $fieldId, $value, array $config, string $errorClass): string
    {
        $attributes = $this->buildAttributes($config, ['id' => $fieldId, 'name' => $fieldId, 'class' => "form-control {$errorClass}", 'rows' => $config['rows'] ?? 3]);
        $attributes['placeholder'] = $config['placeholder'] ?? '';

        return "<textarea " . $this->attributesToString($attributes) . ">" . htmlspecialchars($value ?? '') . "</textarea>";
    }

    /**
     * Render richtext field
     */
    private function renderRichtextField(string $fieldId, $value, array $config, string $errorClass): string
    {
        $attributes = $this->buildAttributes($config, ['id' => $fieldId, 'name' => $fieldId, 'class' => "form-control richtext-editor {$errorClass}"]);
        $attributes['placeholder'] = $config['placeholder'] ?? '';

        return "<textarea " . $this->attributesToString($attributes) . ">" . htmlspecialchars($value ?? '') . "</textarea>";
    }

    /**
     * Render select field
     */
    private function renderSelectField(string $fieldId, $value, array $config, string $errorClass): string
    {
        $attributes = $this->buildAttributes($config, ['id' => $fieldId, 'name' => $fieldId, 'class' => "form-select {$errorClass}"]);

        $html = "<select " . $this->attributesToString($attributes) . ">";
        $html .= "<option value=\"\">Pilih {$config['label']}</option>";

        if (isset($config['options'])) {
            foreach ($config['options'] as $optionValue => $optionLabel) {
                $selected = ($value == $optionValue) ? 'selected' : '';
                $html .= "<option value=\"{$optionValue}\" {$selected}>{$optionLabel}</option>";
            }
        }

        $html .= "</select>";
        return $html;
    }

    /**
     * Render checkbox field
     */
    private function renderCheckboxField(string $fieldId, $value, array $config): string
    {
        $checked = $value ? 'checked' : '';
        $attributes = $this->buildAttributes($config, ['type' => 'checkbox', 'id' => $fieldId, 'name' => $fieldId, 'value' => '1', 'class' => 'form-check-input']);

        $html = "<div class=\"form-check\">";
        $html .= "<input " . $this->attributesToString($attributes) . " {$checked}>";
        $html .= "<label class=\"form-check-label\" for=\"{$fieldId}\">{$config['label']}</label>";
        $html .= "</div>";

        return $html;
    }

    /**
     * Render date/time field
     */
    private function renderDateTimeField(string $type, string $fieldId, $value, array $config, string $errorClass): string
    {
        $attributes = $this->buildAttributes($config, ['type' => $type, 'id' => $fieldId, 'name' => $fieldId, 'value' => $value, 'class' => "form-control {$errorClass}"]);

        return "<input " . $this->attributesToString($attributes) . ">";
    }

    /**
     * Render image field
     */
    private function renderImageField(string $fieldId, $value, array $config, string $errorClass): string
    {
        $html = "<input type=\"file\" id=\"{$fieldId}\" name=\"{$fieldId}\" class=\"form-control {$errorClass}\" accept=\"image/*\">";

        if ($value) {
            $html .= "<div class=\"mt-2\"><img src=\"{$value}\" class=\"img-thumbnail\" style=\"max-width: 200px; max-height: 200px;\"></div>";
        }

        return $html;
    }

    /**
     * Render group field
     */
    private function renderGroupField(string $name, array $config, $value, string $fieldId): string
    {
        $html = "<div class=\"border rounded p-3 mb-3\">";
        $html .= "<h6 class=\"mb-3\">{$config['label']}</h6>";

        if (isset($config['fields'])) {
            $html .= $this->renderFields($config['fields'], $value ?? [], $fieldId);
        }

        $html .= "</div>";
        return $html;
    }

    /**
     * Render repeater field
     */
    private function renderRepeaterField(string $name, array $config, $value, string $fieldId): string
    {
        $items = $value ?? [];
        if (!is_array($items) || empty($items)) {
            $items = [[]]; // At least one empty item
        }

        $html = "<div class=\"repeater-field\" data-field=\"{$fieldId}\">";
        $html .= "<label class=\"form-label\">{$config['label']}</label>";

        $html .= "<div class=\"repeater-items\">";
        foreach ($items as $index => $item) {
            $html .= "<div class=\"repeater-item border rounded p-3 mb-3\" data-index=\"{$index}\">";
            $html .= "<div class=\"d-flex justify-content-between align-items-center mb-3\">";
            $html .= "<h6 class=\"mb-0\">Item " . ($index + 1) . "</h6>";
            $html .= "<button type=\"button\" class=\"btn btn-sm btn-outline-danger remove-item\" " . (count($items) <= ($config['min_items'] ?? 1) ? 'disabled' : '') . ">Hapus</button>";
            $html .= "</div>";

            if (isset($config['fields'])) {
                $html .= $this->renderFields($config['fields'], $item, "{$fieldId}[{$index}]");
            }

            $html .= "</div>";
        }
        $html .= "</div>";

        $html .= "<button type=\"button\" class=\"btn btn-sm btn-outline-primary add-item\">Tambah Item</button>";

        // Store template for JavaScript
        $template = "<div class=\"repeater-item border rounded p-3 mb-3\" data-index=\"__INDEX__\">";
        $template .= "<div class=\"d-flex justify-content-between align-items-center mb-3\">";
        $template .= "<h6 class=\"mb-0\">Item __DISPLAY_INDEX__</h6>";
        $template .= "<button type=\"button\" class=\"btn btn-sm btn-outline-danger remove-item\">Hapus</button>";
        $template .= "</div>";
        $template .= $this->renderFields($config['fields'] ?? [], [], "{$fieldId}[__INDEX__]");
        $template .= "</div>";

        $html .= "<script type=\"text/template\" class=\"repeater-template\">" . addslashes($template) . "</script>";

        $html .= "</div>";

        return $html;
    }

    /**
     * Build HTML attributes from config
     */
    private function buildAttributes(array $config, array $defaults = []): array
    {
        $attributes = $defaults;

        if (isset($config['required']) && $config['required']) {
            $attributes['required'] = 'required';
        }

        if (isset($config['placeholder'])) {
            $attributes['placeholder'] = $config['placeholder'];
        }

        if (isset($config['min'])) {
            $attributes['min'] = $config['min'];
        }

        if (isset($config['max'])) {
            $attributes['max'] = $config['max'];
        }

        if (isset($config['step'])) {
            $attributes['step'] = $config['step'];
        }

        return $attributes;
    }

    /**
     * Convert attributes array to HTML string
     */
    private function attributesToString(array $attributes): string
    {
        $strings = [];
        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $strings[] = $key;
            } elseif ($value !== false && $value !== null) {
                $strings[] = $key . '="' . htmlspecialchars($value) . '"';
            }
        }
        return implode(' ', $strings);
    }

    /**
     * Validate form data against schema
     */
    public function validateData(array $schema, array $data): array
    {
        $errors = [];

        foreach ($schema as $fieldName => $fieldConfig) {
            $value = data_get($data, $fieldName);
            $fieldErrors = $this->validateField($fieldName, $fieldConfig, $value);

            if (!empty($fieldErrors)) {
                $errors[$fieldName] = $fieldErrors;
            }
        }

        return $errors;
    }

    /**
     * Validate single field
     */
    private function validateField(string $fieldName, array $config, $value): array
    {
        $errors = [];
        $label = $config['label'] ?? ucfirst($fieldName);

        // Required validation
        if (isset($config['required']) && $config['required']) {
            if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                $errors[] = "{$label} wajib diisi";
            }
        }

        // Type-specific validation
        if ($value !== null && $value !== '') {
            $type = $config['type'] ?? 'text';

            switch ($type) {
                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "{$label} harus berupa email yang valid";
                    }
                    break;

                case 'url':
                    if (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $errors[] = "{$label} harus berupa URL yang valid";
                    }
                    break;

                case 'number':
                    if (!is_numeric($value)) {
                        $errors[] = "{$label} harus berupa angka";
                    } else {
                        $numValue = (float) $value;
                        if (isset($config['min']) && $numValue < $config['min']) {
                            $errors[] = "{$label} minimal {$config['min']}";
                        }
                        if (isset($config['max']) && $numValue > $config['max']) {
                            $errors[] = "{$label} maksimal {$config['max']}";
                        }
                    }
                    break;

                case 'repeater':
                    if (isset($config['min_items']) && is_array($value) && count($value) < $config['min_items']) {
                        $errors[] = "{$label} minimal {$config['min_items']} item";
                    }
                    if (isset($config['max_items']) && is_array($value) && count($value) > $config['max_items']) {
                        $errors[] = "{$label} maksimal {$config['max_items']} item";
                    }
                    // Validate each item in repeater
                    if (is_array($value) && isset($config['fields'])) {
                        foreach ($value as $index => $item) {
                            $itemErrors = $this->validateData($config['fields'], $item ?? []);
                            if (!empty($itemErrors)) {
                                foreach ($itemErrors as $itemField => $itemFieldErrors) {
                                    $errors["{$fieldName}.{$index}.{$itemField}"] = $itemFieldErrors;
                                }
                            }
                        }
                    }
                    break;

                case 'group':
                    if (isset($config['fields'])) {
                        $groupErrors = $this->validateData($config['fields'], $value ?? []);
                        if (!empty($groupErrors)) {
                            foreach ($groupErrors as $groupField => $groupFieldErrors) {
                                $errors["{$fieldName}.{$groupField}"] = $groupFieldErrors;
                            }
                        }
                    }
                    break;
            }
        }

        return $errors;
    }
}
