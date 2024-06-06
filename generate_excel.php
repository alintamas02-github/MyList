<?php
if (isset($_POST['export'])) {
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $results = isset($_POST['data']) ? json_decode($_POST['data'], true) : array();

    // Setăm antetul pentru fișierul CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sales_report.csv"');

    // Deschidem fluxul de ieșire către fișier
    $output = fopen('php://output', 'w');

    // Scriem antetul în fișier
    $header = array('Date', 'Product Title', 'Buying Price', 'Selling Price', 'Total Qty', 'TOTAL');
    fputcsv($output, $header);

    // Scriem datele în fișier
    foreach ($results as $result) {
        $row = array(
            $result['date'],
            ucfirst($result['name']),
            $result['buy_price'],
            $result['sale_price'],
            $result['total_sales'],
            $result['total_saleing_price']
        );
        fputcsv($output, $row);
    }

    // Închidem fluxul de ieșire către fișier
    fclose($output);
    exit;
}
?>
