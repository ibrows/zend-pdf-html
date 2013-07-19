<?php

require 'vendor/autoload.php';

use Dominikzogg\ZendPdfHtml\HtmlPage;
use ZendPdf\PdfDocument;
use ZendPdf\Page;


$pdf = new PdfDocument();
$page = new Page(Page::SIZE_A4_LANDSCAPE);


$html = new HtmlPage($page);
$html->drawHtml('Hans<h4><strong>Dies</strong> ist <strong>ein</strong> Test</h4><ul><li>Punkt1</li><li>Punkt2</li></ul>Urs', 30, 30, 130, 130);























$pdf->pages[] = $page;
$pdfContent = $pdf->render();

header("HTTP/1.0 200 OK");
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="downloaded.pdf"');
header('Content-Length: ' . strlen($pdfContent));

print $pdfContent;