<?php namespace AlistairShaw\NameExploder\Name;

use AlistairShaw\NameExploder\Suffix\Suffix;
use AlistairShaw\NameExploder\Title\Title;

class Name {

    /**
     * @var Title
     */
    private $title;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $middleInitial;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var Suffix[]
     */
    private $suffixes;

    /**
     * Name constructor.
     * @param string $firstName
     * @param string $middleInitial
     * @param string $lastName
     * @param Title  $title
     * @param Suffix[]  $suffixes
     */
    public function __construct($firstName, $middleInitial, $lastName, Title $title = null, array $suffixes = [])
    {
        $this->title = $title;
        $this->firstName = $firstName;
        $this->middleInitial = $middleInitial;
        $this->lastName = $lastName;
        $this->suffixes = $suffixes;
    }

    /**
     * @return Title
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function middleInitial()
    {
        return $this->middleInitial;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function suffix()
    {
        return count($this->suffixes)
            ? trim(array_reduce($this->suffixes, fn($carry, $suffix) => "{$suffix} {$carry}"))
            : '';
    }

    /**
     * @param Title $newTitle
     * @return $this
     */
    public function updateTitle(Title $newTitle)
    {
        $this->title = $newTitle;
        return $this;
    }

    /**
     * Format the pieces to allow sort & display by last name first.
     * There are various styles (MLA, Chicago, etc.) which are vague or
     * contradictory about order and inclusion of titles and suffixes, so
     * a more robust package might offer a flag to format in conformance with a
     * particular style. But all agree[1] on the trivial case of "Last, First",
     * and if there's only one name it should be "Last" or "First", omitting the
     * comma. For this package I'm assuming that if all fields are entered it
     * should return "Last, First Suffix (Title)".
     * E.g. "King, Martin Luther Junior (Doctor)"
     *
     * [1] Citation needed.
     *
     * @return string
     */
    public function lastFirst()
    {
        $nameArray = [];
        if ($this->lastName) {
            $nameArray[] = $this->firstName
                ? $this->lastName().','
                : $this->lastName();
        }
        if ($this->firstName) $nameArray[] = $this->firstName();
        if ($this->middleInitial()) $nameArray[] = $this->middleInitial();
        if ($this->suffixes) $nameArray[] = $this->suffix();
        if ($this->title) $nameArray[] = '('.(string)$this->title().')';

        return implode(' ', $nameArray);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $nameArray = [];
        if ($this->title) $nameArray[] = (string)$this->title();
        if ($this->firstName) $nameArray[] = $this->firstName();
        if ($this->middleInitial()) $nameArray[] = $this->middleInitial();
        if ($this->lastName) $nameArray[] = $this->lastName();
        if ($this->suffixes) $nameArray[] = $this->suffix();

        return implode(' ', $nameArray);
    }

}