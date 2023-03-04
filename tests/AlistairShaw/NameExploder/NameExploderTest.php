<?php declare(strict_types=1);

namespace AlistairShaw\NameExploder\Test;

use AlistairShaw\NameExploder\NameExploder;
use PHPUnit\Framework\TestCase;

final class NameExploderTest extends TestCase {

    public function testExplodeNameEnglish()
    {
        $exploder = new NameExploder('en');

        $name = $exploder->explode('Mr Alistair Shaw');
        $this->assertEquals('Mr', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Shaw, Alistair (Mr)', $name->lastFirst());
        $this->assertEquals('Mr Alistair Shaw', (string)$name);

        $name = $exploder->explode('Mr Alistair M Shaw');
        $this->assertEquals('Mr', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('M', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Shaw, Alistair M (Mr)', $name->lastFirst());
        $this->assertEquals('Mr Alistair M Shaw', (string)$name);

        $name = $exploder->explode('Alistair Shaw');
        $this->assertEquals('', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Shaw, Alistair', $name->lastFirst());
        $this->assertEquals('Alistair Shaw', (string)$name);

        $name = $exploder->explode('Alistair M');
        $this->assertEquals('', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('M', $name->lastName());
        $this->assertEquals('M, Alistair', $name->lastFirst());
        $this->assertEquals('Alistair M', (string)$name);

        $name = $exploder->explode('AM Shaw');
        $this->assertEquals('', $name->title());
        $this->assertEquals('A', $name->firstName());
        $this->assertEquals('M', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Shaw, A M', $name->lastFirst());
        $this->assertEquals('A M Shaw', (string)$name);

        $name = $exploder->explode('A M Shaw');
        $this->assertEquals('', $name->title());
        $this->assertEquals('A', $name->firstName());
        $this->assertEquals('M', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Shaw, A M', $name->lastFirst());
        $this->assertEquals('A M Shaw', (string)$name);

        $name = $exploder->explode('Col Shaw');
        $this->assertEquals('Colonel', $name->title());
        $this->assertEquals('', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Shaw (Colonel)', $name->lastFirst());
        $this->assertEquals('Colonel Shaw', (string)$name);

        $name = $exploder->explode('Alistair');
        $this->assertEquals('', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('', $name->lastName());
        $this->assertEquals('Alistair', $name->lastFirst());
        $this->assertEquals('Alistair', (string)$name);

        $name = $exploder->explode('Dr Alistair M Shaw III, MD PhD');
        $this->assertEquals('Doctor', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('M', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('III MD PhD', $name->suffix());
        $this->assertEquals('Shaw, Alistair M III MD PhD (Doctor)', $name->lastFirst());
        $this->assertEquals('Doctor Alistair M Shaw III MD PhD', (string)$name);

        $name = $exploder->explode('Alistair Shaw, Jr.');
        $this->assertEquals('', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Junior', $name->suffix());
        $this->assertEquals('Shaw, Alistair Junior', $name->lastFirst());
        $this->assertEquals('Alistair Shaw Junior', (string)$name);
    }

    public function testExplodeNameSpanish()
    {
        $exploder = new NameExploder('es');

        $name = $exploder->explode('Sr Alistair Enrico Shaw Hernandez');
        $this->assertEquals('Sr', (string)$name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('Enrico', $name->middleInitial());
        $this->assertEquals('Shaw Hernandez', $name->lastName());
        $this->assertEquals('Sr Alistair Enrico Shaw Hernandez', (string)$name);

        $name = $exploder->explode('Señor Alistair M Shaw');
        $this->assertEquals('Sr', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('M', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Sr Alistair M Shaw', (string)$name);

        $name = $exploder->explode('Señorita Alistair Shaw');
        $this->assertEquals('Srta', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Srta Alistair Shaw', (string)$name);
    }

    public function testImplodeName()
    {
        $exploder = new NameExploder('en');
        $name = $exploder->implode('Alistair', 'Shaw', '', '', '');

        $this->assertEquals('', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('', $name->suffix());
        $this->assertEquals('Alistair Shaw', (string)$name);

        $name = $exploder->implode('Alistair', 'Shaw', '', 'Mr', 'Jr');

        $this->assertEquals('Mr', $name->title());
        $this->assertEquals('Alistair', $name->firstName());
        $this->assertEquals('', $name->middleInitial());
        $this->assertEquals('Shaw', $name->lastName());
        $this->assertEquals('Junior', $name->suffix());
        $this->assertEquals('Mr Alistair Shaw Junior', (string)$name);
    }

    public function testUpdateTitle()
    {
        $exploder = new NameExploder('en');
        $name = $exploder->implode('Alistair', 'Shaw', '', 'Mr');

        $name = $exploder->updateTitle($name, 'Doctor');

        $this->assertEquals('Doctor', (string)$name->title());
    }
}