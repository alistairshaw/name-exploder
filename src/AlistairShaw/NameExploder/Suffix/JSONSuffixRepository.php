<?php namespace AlistairShaw\NameExploder\Suffix;

use ReflectionClass;

class JSONSuffixRepository implements SuffixRepository {

    private $rootDataSource;

    /**
     * Override the constructor in your custom SuffixRepository and you can set
     * the data source root to wherever you need.
     */
    public function __construct()
    {
        // this is to get the right path to the vendor json files
        $reflector = new ReflectionClass('AlistairShaw\NameExploder\Suffix\JSONSuffixRepository');
        $this->rootDataSource = dirname($reflector->getFileName()) . '/../../../Data/suffixes/';
    }

    /**
     * @param string $language
     * @param int    $maxUsage
     * @return array
     */
    public function availableSuffixes($language = 'en', $maxUsage = 100)
    {
        $suffixes = $this->getSuffixArrayFromFile($language);
        $final = [];
        foreach ($suffixes as $suffix)
        {
            if ($suffix->usageScore <= $maxUsage) $final[] = $this->suffixObjectFromFileObject($suffix);
        }
        return $final;
    }

    /**
     * @param        $findSuffix
     * @param string $language
     * @return Suffix | false if none found
     */
    public function find($findSuffix, $language = 'en')
    {
        if (! $findSuffix) return false;
        $suffixes = $this->getSuffixArrayFromFile($language);
        foreach ($suffixes as $suffix)
        {
            if ($suffix->primary == $findSuffix || in_array($findSuffix, explode('|', $suffix->equivalents)))
                return $this->suffixObjectFromFileObject($suffix);
        }
        return false;
    }

    /**
     * @param $suffix
     * @return Suffix
     */
    private function suffixObjectFromFileObject($suffix)
    {
        return new Suffix($suffix->primary, $suffix->language, explode('|', $suffix->equivalents), $suffix->usageScore);
    }

    /**
     * @param $language
     * @return mixed
     */
    private function getSuffixArrayFromFile($language)
    {
        $file = $this->rootDataSource . $language . '/suffixes.json';
        return json_decode(file_get_contents($file));
    }
}