<?php

require 'vendor/autoload.php';

use Ibrows\ZendPdfHtml\HtmlDrawer;
use Ibrows\ZendPdfHtml\Parser\Tag;
use ZendPdf\PdfDocument;
use ZendPdf\Page;


$pdf = new PdfDocument();
$page = new Page(Page::SIZE_A4_LANDSCAPE);

$htmlPage = new HtmlDrawer();
$htmlPage->getParser()->registerTag(new Tag\Br());
$htmlPage->getParser()->registerTag(new Tag\Em());
$htmlPage->getParser()->registerTag(new Tag\H4());
$htmlPage->getParser()->registerTag(new Tag\Li());
$htmlPage->getParser()->registerTag(new Tag\P());
$htmlPage->getParser()->registerTag(new Tag\Strong());
$htmlPage->getParser()->registerTag(new Tag\Ul());
$htmlPage->drawHtml($page, '<h4>Produktbeschrieb</h4>
<ul>
<li>Winkelprofile mit Wandstärke 2.3 mm</li>
<li>Randzone konisch verjüngt als Einführhilfe</li>
<li>Längsrillen zur Markierung des minimalen Randabstandes<br />für Befestigungsmittel</li>
</ul>
<h4>Material</h4>
<p>Aluminium ENAW-6060</p>
<h4>Spezifikationen</h4>
<ul>
<li>Zuschnitt und Positionierung</li>
<li>Gehrungsschnitte</li>
<li>Ausklinkungen</li>
<li>Schweissen / Vernieten von Eckelementen</li>
</ul>', 30, 530, 330, 30);

$pdf->pages[] = $page;
$pdfContent = $pdf->render();

header("HTTP/1.0 200 OK");
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="downloaded.pdf"');
header('Content-Length: ' . strlen($pdfContent));

print $pdfContent;
