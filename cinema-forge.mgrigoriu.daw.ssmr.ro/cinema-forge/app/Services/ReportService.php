<?php
namespace Services;
// generarea fisierelor de export, intr-un singur loc pentru toate rapoartele

class ReportService {

    /**
     * export excel prin spreadsheetml: fisierul se deschide nativ in excel
     * si in libreoffice, spre deosebire de un simplu csv
     */
    public static function excel($filename, array $columns, array $rows) {
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '-' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        echo "\xEF\xBB\xBF"; // bom, ca diacriticele sa fie citite corect
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel"><head><meta charset="UTF-8"></head><body>';
        echo '<table border="1"><thead><tr>';
        foreach ($columns as $label) {
            echo '<th>' . htmlspecialchars($label) . '</th>';
        }
        echo '</tr></thead><tbody>';

        foreach ($rows as $row) {
            echo '<tr>';
            foreach (array_keys($columns) as $field) {
                echo '<td>' . htmlspecialchars((string) ($row[$field] ?? '')) . '</td>';
            }
            echo '</tr>';
        }

        echo '</tbody></table></body></html>';
        exit;
    }

    public static function csv($filename, array $columns, array $rows) {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '-' . date('Y-m-d') . '.csv"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, array_values($columns));

        foreach ($rows as $row) {
            $line = [];
            foreach (array_keys($columns) as $field) {
                $line[] = $row[$field] ?? '';
            }
            fputcsv($out, $line);
        }

        fclose($out);
        exit;
    }
}
