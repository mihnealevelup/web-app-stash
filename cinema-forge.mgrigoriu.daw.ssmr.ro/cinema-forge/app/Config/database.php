
<?php
// app/Helpers/TableGenerator.php

class TableGenerator {
    public static function render($data, $columns, $actions=[]) {
        if (empty($data)) return '<div class="alert alert-info">No records found.</div>';

        $html = '<table class="table table-striped table-hover">';
        $html.= '<thead class="table-dark"><tr>';

        // generare antet
        foreach ($columns as $dbField => $label) {
            $html.= '<th>'. htmlspecialchars($label). '</th>';
        }
        if (!empty($actions)) $html.= '<th>Actions</th>';

        $html.= '</tr></thead><tbody>';

        // generare randuri
        foreach ($data as $row) {
            $html.= '<tr>';
            foreach ($columns as $dbField => $label) {
                // gestionam cazurile in care campul nu exista sau e null
                $value = isset($row[$dbField])? htmlspecialchars($row[$dbField]) : '-';
                $html.= "<td>{$value}</td>";
            }

            // generare butoane de acțiune
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
}