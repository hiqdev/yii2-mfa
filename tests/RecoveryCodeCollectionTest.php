<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \hiqdev\yii2\mfa\base\RecoveryCodeCollection;

class RecoveryCodeCollectionTest extends TestCase
{

    private $recovery;

    public function setUp(): void
    {
        $this->recovery = new RecoveryCodeCollection();
    }

    public function testGetCount(): void
    {
       $this->assertEquals(10, $this->recovery->getCount());
    }

    public function testSetCount(): void
    {
        $count = 5;
        $this->recovery->setCount($count);
        $this->assertEquals($count, $this->recovery->getCount());
    }

    public function testGetBlocks(): void
    {
        $this->assertEquals(4, $this->recovery->getBlocks());
    }

    public function testSetBlocks(): void
    {
        $count = 5;
        $this->recovery->setBlocks($count);
        $this->assertEquals($count, $this->recovery->getBlocks());
    }

    public function testGetBlockLength(): void
    {
        $this->assertEquals(3, $this->recovery->getBlockLength());
    }

    public function testSetBlockLength(): void
    {
        $count = 5;
        $this->recovery->setBlockLength($count);
        $this->assertEquals($count, $this->recovery->getBlockLength());
    }

    public function testGetBlockSeparator(): void
    {
        $this->assertEquals('-', $this->recovery->getBlockSeparator());
    }

    public function testSetBlockSeparator(): void
    {
        $sep = '.';
        $this->recovery->setBlockSeparator($sep);
        $this->assertEquals($sep, $this->recovery->getBlockSeparator());
    }

    public function testGenerate(): void
    {
        // number of generated codes is correct?
        $codes = $this->recovery->generate()->getCodes();
        $this->assertEquals($this->recovery->getCount(), count($codes));

        // number of code blocks is correct?
        $firstCode = $codes[0];
        $codeBlocks = explode($this->recovery->getBlockSeparator(), $firstCode);
        $this->assertEquals($this->recovery->getBlocks(), count($codeBlocks));

        // length of one code block is correct?
        $firstBlock = $codeBlocks[0];
        $this->assertEquals($this->recovery->getBlockLength() * 2, strlen($firstBlock));
    }



}