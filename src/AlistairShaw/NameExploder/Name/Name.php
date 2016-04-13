<?php namespace AlistairShaw\NameExploder\Name;

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
     * Name constructor.
     * @param Title  $title
     * @param string $firstName
     * @param string $middleInitial
     * @param string $lastName
     */
    public function __construct($firstName, $middleInitial, $lastName, Title $title = null)
    {
        $this->title = $title;
        $this->firstName = $firstName;
        $this->middleInitial = $middleInitial;
        $this->lastName = $lastName;
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
    public function __toString()
    {
        $nameArray = [];
        if ($this->title) $nameArray[] = (string)$this->title();
        if ($this->firstName) $nameArray[] = $this->firstName();
        if ($this->middleInitial()) $nameArray[] = $this->middleInitial();
        if ($this->lastName) $nameArray[] = $this->lastName();

        return implode(' ', $nameArray);
    }

}