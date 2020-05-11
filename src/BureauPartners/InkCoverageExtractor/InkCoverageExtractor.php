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
    protected $command  = 'gs  -dSAFER -dNOPAUSE -dBATCH -o- -sDEVICE=ink_cov';
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

            $match       = trim($match);
            $match       = preg_replace('/\s+/', ' ', $match);
            $match_parts = explode(' ', $match);
            if ($current_page > 0 && count($match_parts) > 0 && is_numeric($match_parts[0])) {
                $color_c                    = $match_parts[0];
                $color_m                    = $match_parts[1];
                $color_y                    = $match_parts[2];
                $color_k                    = $match_parts[3];
                $this->pages[$current_page] = [
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
