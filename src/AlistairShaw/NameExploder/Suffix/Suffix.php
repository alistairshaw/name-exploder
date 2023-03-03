<?php namespace AlistairShaw\NameExploder\Suffix;

class Suffix {

    /**
     * @var string
     */
    private $display;

    /**
     * @var string
     */
    private $language;

    /**
     * @var array
     */
    private $equivalents;

    /**
     * @var int
     */
    private $usageScore;

    /**
     * Suffix constructor.
     * @param        $display
     * @param string $language
     * @param array  $equivalents
     * @param int    $usageScore
     */
    public function __construct($display, $language = 'en', $equivalents = [], $usageScore = 1)
    {
        $this->display = $display;
        $this->language = $language;
        $this->equivalents = $equivalents;
        $this->usageScore = $usageScore;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->display;
    }

}