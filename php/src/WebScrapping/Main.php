<?php

namespace Chuva\Php\WebScrapping;

use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use OpenSpout\Writer\Common\Creator\WriterEntityFactory;


class Main {


  public static function run(): void {
    $data = Scrapper::scrapFromHtmlFile(__DIR__ . '/../../assets/origin.html');

    $csvPath = __DIR__ . '/../../assets/saida.csv';

    $writer = WriterEntityFactory::createCSVWriter();
    $writer->openToFile($csvPath);

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
      $rowData = [$paper->id, $paper->title, $paper->type];

      $authors = array_slice($paper->authors, 0, 17);
      for ($i = 0; $i < 17; ++$i) {
        if (isset($authors[$i])) {
          $rowData[] = $authors[$i]->name;
          $rowData[] = $authors[$i]->institution;
        } else {
          $rowData[] = '';
          $rowData[] = '';
        }
      }

      $row = WriterEntityFactory::createRowFromArray($rowData);
      $writer->addRow($row);
    }

    $writer->close();
  }

}