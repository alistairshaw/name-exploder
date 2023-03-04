<?php namespace AlistairShaw\NameExploder\Title;

use ReflectionClass;

class JSONTitleRepository implements TitleRepository {

    private $rootDataSource;

    /**
     * Override the constructor in your custom TitleRepository and you can set the data source
     *   root to wherever you need
     */
    public function __construct()
    {
        // this is to get the right path to the vendor json files
        $reflector = new ReflectionClass('AlistairShaw\NameExploder\Title\JSONTitleRepository');
        $this->rootDataSource = dirname($reflector->getFileName()) . '/../../../Data/titles/';
    }

    /**
     * @param string $language
     * @param int    $maxUsage
     * @return array
     */
    public function availableTitles($language = 'en', $maxUsage = 100)
    {
        $titles = $this->getTitleArrayFromFile($language);
        $final = [];
        foreach ($titles as $title)
        {
            if ($title->usageScore <= $maxUsage) $final[] = $this->titleObjectFromFileObject($title);
        }
        return $final;
    }

    /**
     * @param        $findTitle
     * @param string $language
     * @return Title | false if none found
     */
    public function find($findTitle, $language = 'en')
    {
        if (! $findTitle) return false;
        $titles = $this->getTitleArrayFromFile($language);
        foreach ($titles as $title)
        {
            if ($title->primary == $findTitle || in_array($findTitle, explode('|', $title->equivalents)))
                return $this->titleObjectFromFileObject($title);
        }
        return false;
    }

    /**
     * @param $title
     * @return Title
     */
    private function titleObjectFromFileObject($title)
    {
        return new Title($title->primary, $title->language, explode('|', $title->equivalents), $title->usageScore);
    }

    /**
     * @param $language
     * @return mixed
     */
    private function getTitleArrayFromFile($language)
    {
        $file = $this->rootDataSource . $language . '/titles.json';
        return json_decode(file_get_contents($file));
    }
}