<?php
/*
 * @author Mark Hameetman (BureauPartners B.V.) <mark@bureau.partners>
 * @link https://github.com/bureaupartners/pdf-ink-coverage-extractor
 * @license MIT
 *
 * @copyright Copyright (c) 2020, GRIVOS Holding B.V.
 */

namespace BureauPartners\InkCoverageExtractor;

class InkCoverageExtractor
{
    protected $command  = 'gs  -o - -sDEVICE=inkcov';
    protected $filename = null;
    protected $pages    = [];

    public function __construct($filename)
    {
        $this->filename = $filename;

        return $this->execute();
    }

    private function processOutput($output)
    {
        $current_page = 0;
        foreach ($output as $match) {
            if (substr($match, 0, 5) == 'Page ') {
                $current_page = trim(substr($match, 5, 16));
                continue;
            }

            if ($current_page > 0) {
                $match                                                              = trim($match);
                $match                                                              = preg_replace('/\s+/', ' ', $match);
                list($color_c, $color_m, $color_y, $color_k, $color_model, $status) = explode(' ', $match);
                $this->pages[$current_page]                                         = [
                    'C'   => $color_c,
                    'M'   => $color_m,
                    'Y'   => $color_y,
                    'K'   => $color_k,
                    'sum' => ($color_c + $color_m + $color_y + $color_k),
                ];
                $current_page = 0;
            }
        }

    }

    private function execute($options = null)
    {
        exec($this->command . ' ' . $options . ' ' . $this->filename, $output, $exit_code);
        switch ($exit_code) {
            case 0:
                // matches found
                $this->processOutput($output);
                return true;
                break;
            case 2:
                // error
                return false;
                break;
            default:
                return false;
                break;
        }
    }

    public function getCoverage()
    {
        return $this->pages;
    }
}
