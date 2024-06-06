<?php

require_once('includes/load.php'); // Make sure this points to the right file with the database functions
require('fpdf/fpdf.php'); // Include the FPDF class

// Define the 'MyList' company details
define('COMPANY_LOGO', 'path/to/logo.png'); // Replace with the path to your company logo.
define('COMPANY_NAME', 'MyList');
define('COMPANY_ADDRESS', 'Romania');
define('COMPANY_EMAIL', 'contact@mylist.com');
define('COMPANY_PHONE', '+720 000 000');
define('TAX_RATE', 0.2); // 20% Tax rate for example

class PDF extends FPDF
{
    // Header function to add the logo and company details
    function Header()
    {
        if (file_exists(COMPANY_LOGO)) {
            $this->Image(COMPANY_LOGO, 10, 6, 30);
        }
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, COMPANY_NAME, 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 10, COMPANY_ADDRESS, 0, 1, 'C');
        $this->Cell(0, 10, 'Email: ' . COMPANY_EMAIL . ' Tel: ' . COMPANY_PHONE, 0, 1, 'C');
        $this->Ln(10);
    }

    // Footer function to add the invoice number and page number
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 10, 'Invoice No: ' . rand(1000, 9999), 0, 0, 'C');
    }

    // Function to generate the invoice using data from MySQL
    function generateInvoice($data)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Factura', 0, 1, 'C');
        
        // Add data from MySQL for the invoice
        $subtotal = 0; // Initialize subtotal
        foreach ($data as $sale) {
            $this->SetFont('Arial', '', 12);
            $this->Cell(95, 10, 'Nume: ' . $sale['name'], 0, 0);
            $this->Cell(95, 10, 'Cantitate: ' . $sale['qty'], 0, 1);
            $this->Cell(95, 10, 'Pret: $' . $sale['price'], 0, 0);
            $this->Cell(95, 10, 'Data: ' . $sale['date'], 0, 1);
            $this->Ln(5);
             // Add to subtotal
             $subtotal += floatval($sale['price']);
        }

       // Calculate totals
       $tax = $subtotal * TAX_RATE;
       $total = $subtotal + $tax;
       
       // Display subtotal, tax, and total
       $this->SetFont('Arial', 'B', 12);
       $this->Cell(95, 10, 'Subtotal: $' . number_format($subtotal, 2), 0, 0);
       $this->Cell(95, 10, 'Taxe (' . (TAX_RATE * 100) . '%): $' . number_format($tax, 2), 0, 1);
       $this->Cell(95, 10, 'Total: $' . number_format($total, 2), 0, 0);

        // Payment instructions
        $this->Ln(10);
        $this->SetFont('Arial', 'I', 10);
        $this->MultiCell(0, 10, 'Va rugam sa achitati totalul in maxim 15 zile de la emitere!');
        
        $this->Output('I', 'invoice.pdf'); // Send to the browser and display the invoice
    }
}

// Create a new PDF object
$pdf = new PDF();
$pdf->AliasNbPages(); // Calculate the total number of pages

// Fetch sales data from the database
$data = find_all_sale(); // Replace this with your function to fetch data

// Generate the invoice with data from the database
$pdf->generateInvoice($data);
?>
