<?php namespace AlistairShaw\NameExploder\Suffix;

interface SuffixRepository {

    /**
     * @param string $language
     * @return array
     */
    public function availableSuffixes($language = 'en');

    /**
     * @param        $suffix
     * @param string $language
     * @return mixed
     */
    public function find($suffix, $language = 'en');

}