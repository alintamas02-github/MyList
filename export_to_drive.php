<?php
require_once('includes/load.php');
page_require_level(2); // Asigurați-vă că utilizatorul are nivelul adecvat pentru a accesa această pagină

// Includeți biblioteca client Google API
require 'vendor/autoload.php';

// Configurați clientul Google API
$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->addScope(Google_Service_Drive::DRIVE);

// Creați o instanță a serviciului Google Drive
$driveService = new Google_Service_Drive($client);

// Numele fișierului PDF pe care doriți să îl exportați
$pdfFileName = 'products.pdf';

// Calea către fișierul PDF pe care doriți să îl exportați din export_products.php
$pdfFilePath = 'generated_pdfs/' . $pdfFileName;

// Verificați dacă fișierul PDF există în directorul "generated_pdfs"
if (file_exists($pdfFilePath)) {
    // Creați un fișier Google Drive
    $fileMetadata = new Google_Service_Drive_DriveFile([
        'name' => $pdfFileName,
    ]);
    $content = file_get_contents($pdfFilePath);
    $file = $driveService->files->create($fileMetadata, [
        'data' => $content,
        'mimeType' => 'application/pdf',
        'uploadType' => 'multipart',
    ]);

    // Afișați un mesaj cu link-ul către fișierul din Google Drive
    echo 'Fișierul a fost încărcat cu succes în Google Drive. Link către fișier: ';
    echo '<a href="' . $file->getWebViewLink() . '" target="_blank">' . $file->getWebViewLink() . '</a>';
} else {
    echo 'Fișierul PDF nu există în directorul "generated_pdfs".';
}
?>
