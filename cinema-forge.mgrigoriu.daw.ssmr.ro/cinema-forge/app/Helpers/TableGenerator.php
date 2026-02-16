<?php

namespace Helpers;
class TableGenerator {

    // table method for admin
    public static function render($data, $columns, $actions) {
        if (empty($data)) return '<div class="alert alert-info">No records found.</div>';

        $html = '<table class="table table-striped table-hover">';
        $html.= '<thead class="table-dark"><tr>';

        // generare header
        foreach ($columns as $dbField => $label) {
            $html.= '<th>'. htmlspecialchars($label). '</th>';
        }
        if (!empty($actions)) $html.= '<th>Actions</th>';

        $html.= '</tr></thead><tbody>';

        // generare randuri
        foreach ($data as $row) {
            $html.= '<tr>';
            foreach ($columns as $dbField => $label) {
                // handle cases where the field doesn't exist or it's null
                $value = isset($row[$dbField])? htmlspecialchars($row[$dbField]) : '-';
                $html.= "<td>{$value}</td>";
            }

            // generare butoane de actiune
            if (!empty($actions)) {
                $html.= '<td>';
                foreach ($actions as $action) {
                    $url = str_replace(':id', $row['id'], $action['url']);
                    $class = $action['class']?? 'btn-secondary';
                    $label = $action['label'];
                    $html.= "<a href='{$url}' class='btn btn-sm {$class} me-1'>{$label}</a>";
                }
                $html.= '</td>';
            }
            $html.= '</tr>';
        }

        $html.= '</tbody></table>';
        return $html;
    }

    // grid method for frontend catalog
    public static function renderGrid($data, $config) {
        if (empty($data)) {
            return '<div class="alert alert-info">No records found.</div>';
        }

        $imageField = $config['image'] ?? 'poster_url';
        $titleField = $config['title'] ?? 'title';
        $subtitleField = $config['subtitle'] ?? null;
        $linkPattern = $config['link'] ?? '/film/:id';
        $linkText = $config['linkText'] ?? 'View';
        $defaultImage = $config['defaultImage'] ?? '/assets/images/no-poster.jpg';
        $columns = $config['columns'] ?? 4; // Grid columns

        $html = '<div class="row row-cols-1 row-cols-md-3 row-cols-lg-' . $columns . ' g-4">';

        foreach ($data as $item) {
            $imageUrl = htmlspecialchars($item[$imageField] ?? $defaultImage);
            $title = htmlspecialchars($item[$titleField] ?? 'Untitled');
            $subtitle = $subtitleField ? htmlspecialchars($item[$subtitleField] ?? '') : '';
            $link = str_replace(':id', $item['id'], $linkPattern);

            $html .= '<div class="col">';
            $html .= '<div class="card h-100">';
            $html .= "<img src='{$imageUrl}' class='card-img-top' alt='{$title}'>";
            $html .= '<div class="card-body">';
            $html .= "<h5 class='card-title'>{$title}</h5>";
            if ($subtitle) {
                $html .= "<p class='card-text text-muted'>{$subtitle}</p>";
            }
            $html .= "<a href='{$link}' class='btn btn-primary btn-sm'>{$linkText}</a>";
            $html .= '</div></div></div>';
        }

        $html .= '</div>';
        return $html;
    }

    // generare Filter form
    public static function renderFilters($filters, $action = '') {
        $html = '<form method="GET" action="' . htmlspecialchars($action) . '" class="row g-3 mb-4">';

        foreach ($filters as $name => $config) {
            $label = $config['label'] ?? ucfirst($name);
            $options = $config['options'] ?? [];
            $selected = $config['selected'] ?? '';

            $html .= '<div class="col-md-4">';
            $html .= '<select name="' . htmlspecialchars($name) . '" class="form-select">';
            $html .= '<option value="">All ' . htmlspecialchars($label) . '</option>';

            foreach ($options as $value => $text) {
                $sel = ($selected == $value) ? 'selected' : '';
                $html .= "<option value='" . htmlspecialchars($value) . "' {$sel}>" . htmlspecialchars($text) . "</option>";
            }

            $html .= '</select></div>';
        }

        $html .= '<div class="col-md-4">';
        $html .= '<button type="submit" class="btn btn-primary">Filter</button> ';
        $html .= '<a href="' . htmlspecialchars($action) . '" class="btn btn-secondary">Reset</a>';
        $html .= '</div></form>';

        return $html;
    }
}