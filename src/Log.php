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

use Psr\Log\LogLevel;
use Svile\Pilog\Output\Handle;

class Log
{

    private static $logger = null;

    public static function set($level = LogLevel::DEBUG, $timeFormat = Logger::TIME_FORMAT)
    {
        if (empty(self::$logger)) {
            self::$logger = new Logger($level, $timeFormat);
        } else {
            self::setLevel($level);
            self::setTimeFormat($timeFormat);
        }
    }

    public static function setLevel($level)
    {
        self::get()->setLevel($level);
    }

    public static function setTimeFormat($timeFormat)
    {
        self::get()->setTimeFormat($timeFormat);
    }

    public static function setOutput(Handle $output)
    {
        self::get()->setOutput($output);
    }

    public static function get()
    {
        if (empty(self::$logger)) {
            self::$logger = new Logger();
        }

        return self::$logger;
    }

    public static function emergency($message, array $context = array())
    {
        self::get()->emergency($message, $context);
    }

    public static function alert($message, array $context = array())
    {
        self::get()->alert($message, $context);
    }

    public static function critical($message, array $context = array())
    {
        self::get()->critical($message, $context);
    }

    public static function error($message, array $context = array())
    {
        self::get()->error($message, $context);
    }

    public static function warning($message, array $context = array())
    {
        self::get()->warning($message, $context);
    }

    public static function notice($message, array $context = array())
    {
        self::get()->notice($message, $context);
    }

    public static function info($message, array $context = array())
    {
        self::get()->info($message, $context);
    }

    public static function debug($message, array $context = array())
    {
        self::get()->debug($message, $context);
    }

}
