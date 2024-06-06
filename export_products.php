<?php
require_once('includes/load.php');
require('fpdf/fpdf.php');

// Crearea unei instanțe a clasei PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'List of Products', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function generateProductList($products)
    {
        $this->SetFont('Arial', '', 12);
        foreach ($products as $key => $product) {
            $this->Cell(0, 10, ($key + 1) . '. Product Title: ' . $product['name'], 0, 1);
            $this->Cell(0, 10, 'Category: ' . $product['categorie'], 0, 1);
            $this->Cell(0, 10, 'In-Stock: ' . $product['quantity'], 0, 1);
            $this->Cell(0, 10, 'Buying Price: ' . $product['buy_price'], 0, 1);
            $this->Cell(0, 10, 'Selling Price: ' . $product['sale_price'], 0, 1);
            $this->Cell(0, 10, 'Product Added: ' . read_date($product['date']), 0, 1);
            $this->Ln(5);
        }
    }
}

// Fetch all products from the database
$products = join_product_table();

// Create a new PDF object
$pdf = new PDF();
$pdf->AddPage();

// Generate the product list in the PDF
$pdf->generateProductList($products);

// Output the PDF
$pdf->Output('products.pdf', 'I');
?>
