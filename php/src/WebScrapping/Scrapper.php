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
        $container = $xPath->query("//a[@class='paper-card p-lg bd-gradient-left']");

        $out = [];

        foreach ($container as $article) {
            $id = self::getNodeValue($xPath, $article, ".//div[@class='tags flex-row mr-sm']/div[@class='volume-info']");
            $title = self::getNodeValue($xPath, $article, ".//h4[@class='my-xs paper-title']");
            $tags = self::getNodeValue($xPath, $article, ".//div[@class='tags mr-sm']");
            $authors = self::authors($xPath->query(".//div[@class='authors']/span[@title]", $article));
            $paper = new Paper($id, $title, $tags, $authors);
            $out[] = $paper;
        }

        return $out;
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

    private static function getNodeValue(\DOMXPath $xPath, \DOMNode $contextNode, string $query): string {
        $node = $xPath->query($query, $contextNode)->item(0);

        return $node ? $node->nodeValue : '';
    }
}