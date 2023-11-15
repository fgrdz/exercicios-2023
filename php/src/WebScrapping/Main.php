<?php

namespace Chuva\Php\WebScrapping;

use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use OpenSpout\Writer\Common\Creator\WriterEntityFactory;


class Main {


  public static function run(): void {
    $data = Scrapper::scrapFromHtmlFile(__DIR__ . '/../../assets/origin.html');
    $cPath = __DIR__ . '/../../assets/saida.csv';

    $writer = WriterEntityFactory::createCSVWriter();
    $writer->openToFile($cPath);

    $headerStyle = (new StyleBuilder())
      ->setFontName('Arial')
      ->setFontSize(11)
      ->setFontBold()
      ->setCellAlignment(CellAlignment::RIGHT)
      ->build();

    $headers = ['ID', 'Title', 'Type'];
    for ($i = 0; $i < 17; ++$i) {
      $headers[] = "Author $i";
      $headers[] = "Author $i Institution";
    }
    $headerRow = WriterEntityFactory::createRowFromArray($headers);
    $headerRow->setStyle($headerStyle);
    $writer->addRow($headerRow);

    foreach ($data as $paper) {
      $rowDt = [$paper->id, $paper->title, $paper->type];

      $authors = array_slice($paper->authors, 0, 17);
      for ($i = 0; $i < 17; ++$i) {
        if (isset($authors[$i])) {
          $rowDt[] = $authors[$i]->name;
          $rowDt[] = $authors[$i]->institution;
        } else {
          $rowDt[] = '';
          $rowDt[] = '';
        }
      }

      $row = WriterEntityFactory::createRowFromArray($rowDt);
      $writer->addRow($row);
    }

    $writer->close();
  }

}