<?php

require 'vendor/autoload.php';

use Dominikzogg\ZendPdfHtml\HtmlPage;
use ZendPdf\PdfDocument;
use ZendPdf\Page;


$pdf = new PdfDocument();
$page = new Page(Page::SIZE_A4_LANDSCAPE);


$htmlPage = new HtmlPage($page);
$htmlPage->getParser()->registerTag(new \Dominikzogg\ZendPdfHtml\Parser\Tag\H4());
$htmlPage->getParser()->registerTag(new \Dominikzogg\ZendPdfHtml\Parser\Tag\Em());
$htmlPage->getParser()->registerTag(new \Dominikzogg\ZendPdfHtml\Parser\Tag\Li());
$htmlPage->drawHtml('Hans<h4><em>Dies</em> ist <em>ein</em> Test</h4><ul><li>Punkt1</li><li>Punkt2</li></ul>Urs', 30, 130, 130, 30);























$pdf->pages[] = $page;
$pdfContent = $pdf->render();

header("HTTP/1.0 200 OK");
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="downloaded.pdf"');
header('Content-Length: ' . strlen($pdfContent));

print $pdfContent;