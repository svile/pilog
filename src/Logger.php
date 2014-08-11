<?php

/**
 * Copyright (c) 2014, Svilen Piralkov
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * * Neither the name of Svilen Piralkov nor the names of his
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @package   Pilog
 * @author    Svilen Piralkov
 * @copyright 2014 Svilen Piralkov
 * @license   http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link      http://github.com/svile/pilog
 */

namespace Svile\Pilog;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Svile\Pilog\Output\Handle;

class Logger extends AbstractLogger
{

    const PERMISSION = 0775;
    const TIME_FORMAT = 'Y-m-d H:i:s T';

    private $level = null;
    private $timeFotmat = null;
    private $output = false;

    private $levels = array(
        LogLevel::EMERGENCY => 800,
        LogLevel::ALERT     => 700,
        LogLevel::CRITICAL  => 600,
        LogLevel::ERROR     => 500,
        LogLevel::WARNING   => 400,
        LogLevel::NOTICE    => 300,
        LogLevel::INFO      => 200,
        LogLevel::DEBUG     => 100,
    );

    public function __construct($level = LogLevel::DEBUG, $timeFormat = self::TIME_FORMAT)
    {
        $this->level = $level;
        $this->timeFotmat = $timeFormat;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function setTimeFormat($timeFormat)
    {
        $this->timeFotmat = $timeFormat;
    }

    public function setOutput(Handle $output) 
    {
        $this->output = $output;
    }

    public function log($level, $message, array $context = array())
    {
        if ($this->output === false || $this->levels[$this->level] > $this->levels[$level]) {
            return;
        }

        $this->output->write('['.gmdate($this->timeFotmat).'] '.strtoupper($level).': '.$message
                .(empty($context) ? '' : ' '.json_encode($context)).PHP_EOL);
    }

}
