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

use Psr\Log\LogLevel;
use Svile\Pilog\Logger;
use Svile\Pilog\Output\File;

class LoggerTest extends PHPUnit_Framework_TestCase
{

    public function testEmptyLoggerAndPsr3Interface()
    {
        $log = new Logger();
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $log);
        $log->emergency('This message should not be written anywhere.');
    }

    public function testLoggerNoName()
    {
        $filename = 'loggerfile';
        $log = new Logger();
        $log->setOutput(new File(TEST_DIR, $filename));
        $log->critical('This should be written in file '.$filename.'.log');
        $context = array('sample' => 'key', 'one', 'innerarray' => array('one', 2));
        $log->error('This should also be written in file '.$filename.'.log as default level is DEBUG', $context);

        $this->assertFileExists(TEST_DIR.DIRECTORY_SEPARATOR.$filename.'.log');

        $c = file(TEST_DIR.DIRECTORY_SEPARATOR.$filename.'.log');
        $this->assertNotFalse(strpos($c[0], strtoupper(LogLevel::CRITICAL)));
        $this->assertNotFalse(strpos($c[1], strtoupper(LogLevel::ERROR)));
        $this->assertNotFalse(strpos($c[1], json_encode($context)));
    }

    public function testLoggerWithName()
    {
        $filename = 'noname';
        $log = new Logger(LogLevel::INFO);
        $log->setOutput(new File(TEST_DIR, $filename));
        $log->emergency('This emergency message should be written in file '.$filename.'.log');
        $c1 = array();
        $log->critical('This critical message should be written in file '.$filename.'.log', $c1);
        $c2 = array(1, 2, 3);
        $log->error('This error message should be written in file '.$filename.'.log', $c2);
        $log->warning('This warning message should not be written in file '.$filename.'.log as default level is ERROR');
        $log->notice('This notice message should not be written in file '.$filename.'.log as default level is ERROR');

        $this->assertFileExists(TEST_DIR.DIRECTORY_SEPARATOR.$filename.'.log');

        $c = file(TEST_DIR.DIRECTORY_SEPARATOR.$filename.'.log');
        $this->assertNotFalse(strpos($c[0], strtoupper(LogLevel::EMERGENCY)));
        $this->assertNotFalse(strpos($c[1], strtoupper(LogLevel::CRITICAL)));
        $this->assertNotFalse(strpos($c[2], strtoupper(LogLevel::ERROR)));
    }

}
