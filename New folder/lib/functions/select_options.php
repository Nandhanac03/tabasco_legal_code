<?php
/**
 * Generate <option> elements for a select dropdown.
 *
 * @param array $options Array of options with 'id' and 'name' keys.
 * @param string|null $selectedId The ID of the option to pre-select (optional).
 * @return string Generated HTML options.
 */
function generateSelectOptions(array $options, ?string $selectedId = ''): string {
    if (empty($options)) {
        return '<option disabled>No options available</option>';
    }

    $html = '<option value="">Select</option>';
    foreach ($options as $option) {
        $id = htmlspecialchars($option['id']);
        $title = htmlspecialchars($option['title']);
        $isSelected = ($id === $selectedId) ? 'selected' : '';
        $html .= "<option value=\"{$id}\" {$isSelected}>{$title}</option>";
    }

    return $html;
}
?>


