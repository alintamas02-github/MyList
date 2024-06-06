<?php
require_once('includes/load.php');
require('fpdf/fpdf.php');

// Crearea unei instanțe a clasei PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Lista de categorii', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function generateCategoryList($categories)
    {
        foreach ($categories as $category) {
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, '- ' . $category['name'], 0, 1);
        }
    }
}

// Fetch all categories from the database
$all_categories = find_all('categories');

// Create a new PDF object
$pdf = new PDF();
$pdf->AddPage();

// Generate the category list in the PDF
$pdf->generateCategoryList($all_categories);

// Output the PDF
$pdf->Output('categories.pdf', 'I');
?>
