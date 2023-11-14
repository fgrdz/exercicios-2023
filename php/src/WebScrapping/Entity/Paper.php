<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * The Paper class represents the row of the parsed data.
 */
class Paper {
    /**
     * Paper Id.
     *
     * @var int
     */
    public int $id;

    /**
     * Paper Title.
     *
     * @var string
     */
    public string $title;

    /**
     * The paper type (e.g. Poster, Nobel Prize, etc).
     *
     * @var string
     */
    public string $type;

    /**
     * Paper authors.
     *
     * @var \Chuva\Php\WebScrapping\Entity\Person[]
     */
    public array $authors;

    /**
     * Builder.
     */
    public function __construct($id, $title, $type, $authors = []) {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->authors = (array)$authors;
    }
    
    public function toArray(): array {
        $authorsArray = [];
        foreach ($this->authors as $author) {
            $authorsArray[] = [
                'Name' => $author->name,
                'Institution' => $author->institution,
            ];
        }
    
        return [
            'ID' => $this->id,
            'Title' => $this->title,
            'Type' => $this->type,
            'Authors' => $authorsArray,
        ];
    }
}