<?php

require 'vendor/autoload.php';

use Ibrows\ZendPdfHtml\HtmlDrawer;
use ZendPdf\PdfDocument;
use ZendPdf\Page;


$pdf = new PdfDocument();
$page = new Page(Page::SIZE_A4_LANDSCAPE);

$htmlPage = new HtmlDrawer();
$htmlPage->getParser()->registerTag(new \Ibrows\ZendPdfHtml\Parser\Tag\Br());
$htmlPage->getParser()->registerTag(new \Ibrows\ZendPdfHtml\Parser\Tag\Em());
$htmlPage->getParser()->registerTag(new \Ibrows\ZendPdfHtml\Parser\Tag\H4());
$htmlPage->getParser()->registerTag(new \Ibrows\ZendPdfHtml\Parser\Tag\Li());
$htmlPage->getParser()->registerTag(new \Ibrows\ZendPdfHtml\Parser\Tag\P());
$htmlPage->getParser()->registerTag(new \Ibrows\ZendPdfHtml\Parser\Tag\Strong());
$htmlPage->getParser()->registerTag(new \Ibrows\ZendPdfHtml\Parser\Tag\Ul());
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
