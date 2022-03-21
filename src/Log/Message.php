<?php

/*
 * This file is part of the php-gelf package.
 *
 * (c) Benjamin Zikarsky <http://benjamin-zikarsky.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hillus\SinLaravelGraylog\Log;

use Psr\Log\LogLevel;
use RuntimeException;
use Gelf\MessageInterface;
use Gelf\Message as GelfMessage;

/**
 * A message complying to the GELF standard
 * <https://github.com/Graylog2/graylog2-docs/wiki/GELF>
 *
 * @author Benjamin Zikarsky <benjamin@zikarsky.de>
 */
class Message extends  GelfMessage
{


    private static $psrStringLevels = array(
        'Emergency',    // 0
        'Alert',        // 1
        'Critical',     // 2
        'Error',        // 3
        'Warning',      // 4
        'Notice',       // 5
        'Information',         // 6
        'Debug'         // 7
    );

    final public static function logStringLevelToPsr($level)
    {
        $origLevel = $level;

        if (is_numeric($level)) {
            $level = intval($level);
            if (isset(self::$psrStringLevels[$level])) {
                return self::$psrStringLevels[$level];
            }
        } elseif (is_string($level)) {
            $level = strtolower($level);
            if (in_array($level, self::$psrStringLevels)) {
                return $level;
            }
        }

        throw new RuntimeException(
            sprintf("Cannot convert log-level '%s' to psr-style", $origLevel)
        );
    }


    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function getShortMessage()
    {
        return $this->shortMessage;
    }

    public function setShortMessage($shortMessage)
    {
        $this->shortMessage = $shortMessage;

        return $this;
    }

    public function getFullMessage()
    {
        return $this->fullMessage;
    }

    public function setFullMessage($fullMessage)
    {
        $this->fullMessage = $fullMessage;

        return $this;
    }

    public function getTimestamp()
    {
        return (float) $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        if ($timestamp instanceof \DateTime || $timestamp instanceof \DateTimeInterface) {
            $timestamp = $timestamp->format("U.u");
        }

        $this->timestamp = (float) $timestamp;

        return $this;
    }

    public function getLevel()
    {
        return self::logLevelToPsr($this->level);
    }

    public function getStringLevel()
    {
        return self::logStringLevelToPsr($this->level);
    }

    public function getSyslogLevel()
    {
        return self::logLevelToSyslog($this->level);
    }

    public function setLevel($level)
    {
        $this->level = self::logLevelToSyslog($level);

        return $this;
    }

    public function getFacility()
    {
        return $this->facility;
    }

    public function setFacility($facility)
    {
        $this->facility = $facility;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    public function getAdditional($key)
    {
        if (!isset($this->additionals[$key])) {
            throw new RuntimeException(
                sprintf("Additional key '%s' is not defined", $key)
            );
        }

        return $this->additionals[$key];
    }

    public function hasAdditional($key)
    {
        return isset($this->additionals[$key]);
    }

    public function setAdditional($key, $value)
    {
        $key = (string)$key;
        if ($key === '') {
            throw new RuntimeException("Additional field key cannot be empty");
        }

        $this->additionals[$key] = $value;

        return $this;
    }

    public function getAllAdditionals()
    {
        return $this->additionals;
    }

    public function toArray()
    {
        $message = array(
            'version'       => $this->getVersion(),
            'host'          => $this->getHost(),
            'short_message' => $this->getShortMessage(),
            'full_message'  => $this->getFullMessage(),
            'level'         => $this->getSyslogLevel(),
            'stringLevel'   => $this->getStringLevel(),
            'timestamp'     => $this->getTimestamp(),
            'facility'      => $this->getFacility(),
            'file'          => $this->getFile(),
            'line'          => $this->getLine()
        );

        // Transform 1.1 deprecated fields to additionals
        // Will be refactored for 2.0, see #23
        if ($this->getVersion() == "1.1") {
            foreach (array('line', 'facility', 'file') as $idx) {
                $message["_" . $idx] = $message[$idx];
                unset($message[$idx]);
            }
        }

        // add additionals
        foreach ($this->getAllAdditionals() as $key => $value) {
            $message["_" . $key] = $value;
        }

        // return after filtering empty strings and null values
        return array_filter($message, function ($message) {
            return is_bool($message)
                || (is_string($message) && strlen($message))
                || is_int($message)
                || !empty($message);
        });
    }
}
