<?php
/*
 * @author Mark Hameetman (BureauPartners B.V.) <mark@bureau.partners>
 * @link https://github.com/bureaupartners/pdf-ink-coverage-extractor
 * @license MIT
 *
 * @copyright Copyright (c) 2020, GRIVOS Holding B.V.
 */

declare (strict_types = 1);
use BureauPartners\InkCoverageExtractor\InkCoverageExtractor;
use PHPUnit\Framework\TestCase;

final class InkCoverageExtractorTest extends TestCase
{
    public function testCanGetCoverage()
    {
        $extractor = new InkCoverageExtractor(dirname(__FILE__) . '/pdf/Document.pdf');
        $coverage  = $extractor->getCoverage();
        $this->assertCount(7, $coverage);
        $this->assertEquals(0, $coverage[6]['sum']);
        $this->assertEquals(5.88439, $coverage[5]['C']);
        $this->assertEquals(15.100810000000001, $coverage[7]['sum']);
    }

    public function testCanGetGrayScaleCoverage()
    {
        $extractor = new InkCoverageExtractor(dirname(__FILE__) . '/pdf/Document_grey.pdf');
        $coverage  = $extractor->getCoverage();
        $this->assertCount(7, $coverage);
        $this->assertEquals(0, $coverage[6]['C']);
        $this->assertEquals(0, $coverage[6]['M']);
        $this->assertEquals(0, $coverage[6]['Y']);
        $this->assertEquals(0, $coverage[6]['K']);
        $this->assertEquals(0, $coverage[6]['sum']);
        $this->assertEquals(5.10704, $coverage[7]['sum']);
    }
}
