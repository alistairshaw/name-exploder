<?php namespace AlistairShaw\NameExploder\Title;

interface TitleRepository {

    /**
     * @param string $language
     * @return array
     */
    public function availableTitles($language = 'en');

    /**
     * @param        $title
     * @param string $language
     * @return mixed
     */
    public function find($title, $language = 'en');

}