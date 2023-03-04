<?php declare(strict_types=1);

namespace AlistairShaw\NameExploder\Test;

use AlistairShaw\NameExploder\Title\JSONTitleRepository;
use AlistairShaw\NameExploder\Title\Title;
use PHPUnit\Framework\TestCase;

/**
 * Class JSONTitleRepositoryTest
 * @package AlistairShaw\NameExploder\Test
 *
 * Tests are based on current data from JSON files, if you edit the JSON files,
 *    you may need to change these tests as well to match
 */
final class JSONTitleRepositoryTest extends TestCase {

    /**
     * @var JSONTitleRepository
     */
    private $repository;

    public function __construct($name = '', array $data = [], $dataName = '')
    {
        $this->repository = new JSONTitleRepository();
        parent::__construct($name, $data, $dataName);
    }

    public function testAvailableTitlesEnglish()
    {
        $titles = $this->repository->availableTitles();

        $this->assertEquals(20, count($titles));

        // test first and last one
        $item = $titles[0];
        $this->assertInstanceOf('AlistairShaw\NameExploder\Title\Title', $item);
        $this->assertEquals('Mr', (string)$item);

        $item = $titles[19];
        $this->assertInstanceOf('AlistairShaw\NameExploder\Title\Title', $item);
        $this->assertEquals('Sister', (string)$item);
    }

    public function testAvailableTitlesSpanish()
    {
        $titles = $this->repository->availableTitles();

        $this->assertEquals(20, count($titles));

        // test first and last one
        $item = $titles[0];
        $this->assertInstanceOf('AlistairShaw\NameExploder\Title\Title', $item);
        $this->assertEquals('Mr', (string)$item);

        $item = $titles[19];
        $this->assertInstanceOf('AlistairShaw\NameExploder\Title\Title', $item);
        $this->assertEquals('Sister', (string)$item);
    }

    public function testFind()
    {
        $item = $this->repository->find('Mr');
        $this->assertInstanceOf('AlistairShaw\NameExploder\Title\Title', $item);
        $this->assertEquals('Mr', (string)$item);

        $item = $this->repository->find('BlooBlah');
        $this->assertNotInstanceOf('AlistairShaw\NameExploder\Title\Title', $item);
        $this->assertEquals(false, $item);
    }

}