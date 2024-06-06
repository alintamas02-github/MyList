<?php
$page_title = 'Sales Report';
$results = '';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);

if (isset($_POST['submit'])) {
    $req_dates = array('start-date', 'end-date');
    validate_fields($req_dates);

    if (empty($errors)) {
        $start_date   = remove_junk($db->escape($_POST['start-date']));
        $end_date     = remove_junk($db->escape($_POST['end-date']));
        $results      = find_sale_by_dates($start_date, $end_date);
    } else {
        $session->msg("d", $errors);
        redirect('sales_report.php', false);
    }
} else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
}
?>

<!doctype html>
<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Raport</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <style>
        @media print {
            html,
            body {
                font-size: 9.5pt;
                margin: 0;
                padding: 0;
            }

            .page-break {
                page-break-before: always;
                width: auto;
                margin: auto;
            }
        }

        .page-break {
            width: 980px;
            margin: 0 auto;
        }

        .sale-head {
            margin: 40px 0;
            text-align: center;
        }

        .sale-head h1,
        .sale-head strong {
            padding: 10px 20px;
            display: block;
        }

        .sale-head h1 {
            margin: 0;
            border-bottom: 1px solid #212121;
        }

        .table>thead:first-child>tr:first-child>th {
            border-top: 1px solid #000;
        }

        table thead tr th {
            text-align: center;
            border: 1px solid #ededed;
        }

        table tbody tr td {
            vertical-align: middle;
        }

        .sale-head,
        table.table thead tr th,
        table tbody tr td,
        table tfoot tr td {
            border: 1px solid #212121;
            white-space: nowrap;
        }

        .sale-head h1,
        table thead tr th,
        table tfoot tr td {
            background-color: #f8f8f8;
        }

        tfoot {
            color: #000;
            text-transform: uppercase;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <?php if ($results) : ?>
        <div class="page-break">
            <div class="sale-head">
                <h1>MyList - Sales Report</h1>
                <strong><?php if (isset($start_date)) {
                            echo $start_date;
                        } ?> TILL DATE <?php if (isset($end_date)) {
                                            echo $end_date;
                                        } ?> </strong>
            </div>
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product Title</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Total Qty</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result) : ?>
                        <tr>
                            <td class=""><?php echo remove_junk($result['date']); ?></td>
                            <td class="desc">
                                <h6><?php echo remove_junk(ucfirst($result['name'])); ?></h6>
                            </td>
                            <td class="text-right"><?php echo remove_junk($result['buy_price']); ?></td>
                            <td class="text-right"><?php echo remove_junk($result['sale_price']); ?></td>
                            <td class="text-right"><?php echo remove_junk($result['total_sales']); ?></td>
                            <td class="text-right"><?php echo remove_junk($result['total_saleing_price']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="text-right">
                        <td colspan="4"></td>
                        <td colspan="1">Grand Total</td>
                        <td> $
                            <?php echo number_format(total_price($results)[0], 2); ?>
                        </td>
                    </tr>
                    <tr class="text-right">
                        <td colspan="4"></td>
                        <td colspan="1">Profit</td>
                        <td> $<?php echo number_format(total_price($results)[1], 2); ?></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Add the Exporta în Excel button with JavaScript function -->
            <button id="export-button" class="btn btn-primary" onclick="exportToCSV()">Exporta în Excel</button>
          

        </div>
    <?php
    else :
        $session->msg("d", "Sorry, no sales have been found.");
        redirect('sales_report.php', false);
    endif;
    ?>

    <script>
        // JavaScript code for exporting to CSV
        function exportToCSV() {
    var table = document.querySelector('.table'); // Asigurați-vă că acest selector este corect pentru tabelul dvs.
    var rows = Array.from(table.querySelectorAll('tbody tr:not(:empty)')); // Selectați doar rândurile care nu sunt goale
    var csvData = [];

    // Obțineți antetele tabelului
    var headers = Array.from(table.querySelectorAll('thead th')).map(header => `"${header.textContent.trim()}"`);

    // Adăugați antetele la datele CSV
    csvData.push(headers.join(',')); // Alăturați antetele fără linii noi

    // Parcurgeți rândurile tabelului și adăugați datele rândului la datele CSV
    rows.forEach(function (row) {
        var rowData = Array.from(row.querySelectorAll('td')).map(cell => `"${cell.textContent.trim()}"`);
        // Alăturați datele rândului fără linii noi
        csvData.push(rowData.join(',')); 
    });

    // Creați un șir de conținut CSV
    var csvContent = csvData.join('\n'); // Adăugați aici linii noi

    // Creați un Blob care conține datele CSV
    var blob = new Blob([csvContent], {
        type: 'text/csv;charset=utf-8;'
    });

    // Creați un link de descărcare și declanșați descărcarea
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'sales_report.csv';
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}





    </script>
</body>

</html>

<?php if (isset($db)) {
    $db->db_disconnect();
}
?>
