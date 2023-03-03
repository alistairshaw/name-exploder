<?php namespace AlistairShaw\NameExploder;

use AlistairShaw\NameExploder\Name\Name;
use AlistairShaw\NameExploder\Suffix\JSONSuffixRepository;
use AlistairShaw\NameExploder\Suffix\Suffix;
use AlistairShaw\NameExploder\Suffix\SuffixRepository;
use AlistairShaw\NameExploder\Title\JSONTitleRepository;
use AlistairShaw\NameExploder\Title\Title;
use AlistairShaw\NameExploder\Title\TitleRepository;

class NameExploder {

    /**
     * @var TitleRepository
     */
    private $titleRepository;

    /**
     * @var suffixRepository
     */
    private $suffixRepository;

    /**
     * @var string
     */
    private $language;

    public function __construct($language = 'en', TitleRepository $titleRepository = null, SuffixRepository $suffixRepository = null)
    {
        if ($titleRepository == null)
        {
            $this->titleRepository = new JSONTitleRepository();
        }
        else
        {
            $this->titleRepository = $titleRepository;
        }

        if ($suffixRepository == null)
        {
            $this->suffixRepository = new JSONSuffixRepository();
        }
        else
        {
            $this->suffixRepository = $suffixRepository;
        }

        $this->language = $language;
    }

    /**
     * @param $name
     * @return Name
     */
    public function explode($name)
    {
        // take out characters we don't want
        $name = trim(str_replace(array('.', ','), "", $name));

        $title = null;
        $firstName = '';
        $middleInitial = '';
        $lastName = '';
        $suffixes = [];

        $nameArray = explode(" ", $name);

        // if we only have one item, then it's the first name
        if (count($nameArray) == 1)
        {
            return new Name($nameArray[0], '', '');
        }

        // May have multiple suffixes
        // echo end($nameArray) . "\r";
        // die;
        while ($findSuffix = $this->suffixRepository->find(end($nameArray), $this->language))
        // while ($findSuffix)
        {
            $suffixes[] = $findSuffix;
            array_pop($nameArray);
        }

        if ($findTitle = $this->titleRepository->find($nameArray[0], $this->language))
        {
            $title = $findTitle;
            array_shift($nameArray);
        }

        if (count($nameArray) > 2)
        {
            $middleInitial = $nameArray[1];
            array_splice($nameArray, 1, 1);
        }

        if (count($nameArray) > 1)
        {
            $firstName = $nameArray[0];
            array_shift($nameArray);
        }

        // if the first name is only 2 characters, and the second character is upper case, then it's first and middle initial
        if (strlen($firstName) == 2 && ctype_upper(substr($firstName, 1, 1)))
        {
            $middleInitial = substr($firstName, 1, 1);
            $firstName = substr($firstName, 0, 1);
        }

        // last_name is everything else
        $lastName = implode(' ', $nameArray);

        return new Name($firstName, $middleInitial, $lastName, $title, $suffixes);
    }

    /**
     * @param Name $name
     * @param $title
     * @return Name
     */
    public function updateTitle(Name $name, $title)
    {
        $newTitle = $this->titleRepository->find($title, $this->language);
        $name->updateTitle($newTitle);
        return $name;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $middleInitial
     * @param string $title
     * @param string $suffixes
     * @return Name
     */
    public function implode($firstName = '', $lastName = '', $middleInitial = '', $title = '', $suffixes = '')
    {
        $titleEntity = $this->titleRepository->find($title);
        $suffixEntities = [];
        if ($suffixes) {
            foreach (explode(' ', $suffixes) as $suffix) {
                $suffixEntities[] = $this->suffixRepository->find($suffix);
            }
        }
        return new Name($firstName, $middleInitial, $lastName, $titleEntity ? $titleEntity : null, $suffixEntities ? $suffixEntities : []);
    }

}