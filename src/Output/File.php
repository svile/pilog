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

namespace Svile\Pilog\Output;

/**
 * File output handler
 *
 * @package Svile\Pilog\Output
 */
class File implements Handle
{

    /**
     * Default filename
     */
    const FILENAME = 'main';

    /**
     * @var boolean|resource Opened file
     */
    private $file = false;

    /**
     * Construct
     *
     * @param string $dir  The path to the logs directory
     * @param string $name Filename
     *
     * @return self
     * @throws \RuntimeException Unable to create log directory or open file
     */
    public function __construct($dir, $name = self::FILENAME)
    {
        $dir = rtrim($dir, '\\/');
        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                throw new \RuntimeException('Unable to create log directory.');
            }
        }

        $dir = $dir.DIRECTORY_SEPARATOR.$name.'.log';
        $this->file = fopen($dir, 'a');
        if ($this->file === false) {
            throw new \RuntimeException('Unable to open file.');
        }
    }

    /**
     * Cleanup
     */
    public function __destruct()
    {
        if ($this->file) {
            fclose($this->file);
            $this->file = false;
        }
    }

    /**
     * Writes a message to file
     *
     * @param string $string A message
     * @return void
     * @throws \RuntimeException Unable to write message
     */
    public function write($string)
    {
        if (fwrite($this->file, $string) === false) {
            throw new \RuntimeException('Unable to write to file.');
        }
    }

}
