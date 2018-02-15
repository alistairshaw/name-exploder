<?php namespace AlistairShaw\NameExploder;

use AlistairShaw\NameExploder\Name\Name;
use AlistairShaw\NameExploder\Title\JSONTitleRepository;
use AlistairShaw\NameExploder\Title\Title;
use AlistairShaw\NameExploder\Title\TitleRepository;

class NameExploder {

    /**
     * @var TitleRepository
     */
    private $titleRepository;

    /**
     * @var string
     */
    private $language;

    public function __construct($language = 'en', TitleRepository $titleRepository = null)
    {
        if ($titleRepository == null)
        {
            $this->titleRepository = new JSONTitleRepository();
        }
        else
        {
            $this->titleRepository = $titleRepository;
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

        $nameArray = explode(" ", $name);

        // if we only have one item, then it's the first name
        if (count($nameArray) == 1)
        {
            return new Name($nameArray[0], '', '');
        }

        if ($findTitle = $this->titleRepository->find($nameArray[0], $this->language))
        {
            $title = $findTitle;
            array_splice($nameArray, 0, 1);
        }

        if (count($nameArray) > 2)
        {
            $middleInitial = $nameArray[1];
            array_splice($nameArray, 1, 1);
        }

        if (count($nameArray) > 1)
        {
            $firstName = $nameArray[0];
            array_splice($nameArray, 0, 1);
        }

        // if the first name is only 2 characters, and the second character is upper case, then it's first and middle initial
        if (strlen($firstName) == 2 && ctype_upper(substr($firstName, 1, 1)))
        {
            $middleInitial = substr($firstName, 1, 1);
            $firstName = substr($firstName, 0, 1);
        }

        // last_name is everything else
        foreach ($nameArray as $n)
        {
            $lastName .= $n;
        }

        return new Name($firstName, $middleInitial, $lastName, $title);
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
     * @return Name
     */
    public function implode($firstName = '', $lastName = '', $middleInitial = '', $title = '')
    {
        $titleEntity = $this->titleRepository->find($title);
        return new Name($firstName, $middleInitial, $lastName, $titleEntity ? $titleEntity : null);
    }

}