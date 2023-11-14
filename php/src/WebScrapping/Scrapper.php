<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

class Scrapper {

    public static function scrapFromHtmlFile(string $filePath): array {
        $dom = new \DOMDocument('1.0', 'utf-8');
        @$dom->loadHTMLFile($filePath);

        return self::scrap($dom);
    }

    public static function scrap(\DOMDocument $dom): array {
        $xPath = new \DOMXPath($dom);
        $containerArticles = $xPath->query("//a[@class='paper-card p-lg bd-gradient-left']");
        $results = [];

        foreach ($containerArticles as $article) {
            $id = $xPath->query(".//div[@class='tags flex-row mr-sm']/div[@class='volume-info']", $article)->item(0)->nodeValue;
            $title = $xPath->query(".//h4[@class='my-xs paper-title']", $article)->item(0)->nodeValue;
            $tags = $xPath->query(".//div[@class='tags mr-sm']", $article)->item(0)->nodeValue;
            $authors = self::authors($xPath->query(".//div[@class='authors']/span[@title]", $article));

            $paper = new Paper($id, $title, $tags, $authors);
            $results[] = $paper;
        }

        return $results;
    }

    private static function authors(\DOMNodeList $nodes): array {
        $authors = [];

        foreach ($nodes as $node) {
            $name = $node->nodeValue;
            $title = $node->getAttribute('title');
            $author = new Person($name, $title);
            $authors[] = $author;
        }

        return $authors;
    }
}