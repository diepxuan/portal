<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-07-03 11:05:32
 */

namespace Diepxuan\Log;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    /**
     * The LogToChannels channels.
     *
     * @var Logger[]
     */
    protected $channels = [];

    /**
     * LogToChannels constructor.
     */
    public function __construct() {}

    /**
     * @param string $channel The channel to log the record in
     * @param int    $level   The error level
     * @param string $message The error message
     * @param array  $context Optional context arguments
     *
     * @return bool Whether the record has been processed
     */
    public function log(string $channel, int $level, string $message, array $context = []): bool
    {
        // Add the logger if it doesn't exist
        if (!isset($this->channels[$channel])) {
            $handler = new StreamHandler(
                storage_path() . \DIRECTORY_SEPARATOR . 'logs' . \DIRECTORY_SEPARATOR . $channel . '.log'
            );

            $handler->setFormatter(new LineFormatter(null, null, true, true));

            $this->addChannel($channel, $handler);
        }

        return $this->channels[$channel]->{Logger::getLevelName($level)}($message, $context);
    }

    /**
     * Add a channel to log in.
     *
     * @param string           $channelName The channel name
     * @param HandlerInterface $handler     The channel handler
     * @param null|string      $path        The path of the channel file, DEFAULT storage_path()/logs
     *
     * @throws \Exception When the channel already exists
     */
    public function addChannel(string $channelName, HandlerInterface $handler, ?string $path = null): void
    {
        if (isset($this->channels[$channelName])) {
            throw new \Exception('This channel already exists');
        }

        $this->channels[$channelName] = new Logger($channelName);
        $this->channels[$channelName]->pushHandler(
            new $handler(
                null === $path ?
                    storage_path() . \DIRECTORY_SEPARATOR . 'logs' . \DIRECTORY_SEPARATOR . $channelName . '.log' :
                    $path . \DIRECTORY_SEPARATOR . $channelName . '.log'
            )
        );
    }

    /**
     * Adds a log record at the DEBUG level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function debug(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::DEBUG, $message, $context);
    }

    /**
     * Adds a log record at the INFO level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function info(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::INFO, $message, $context);
    }

    /**
     * Adds a log record at the NOTICE level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function notice(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::NOTICE, $message, $context);
    }

    /**
     * Adds a log record at the WARNING level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function warn(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::WARNING, $message, $context);
    }

    /**
     * Adds a log record at the WARNING level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function warning(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::WARNING, $message, $context);
    }

    /**
     * Adds a log record at the ERROR level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function err(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::ERROR, $message, $context);
    }

    /**
     * Adds a log record at the ERROR level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function error(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::ERROR, $message, $context);
    }

    /**
     * Adds a log record at the CRITICAL level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function crit(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::CRITICAL, $message, $context);
    }

    /**
     * Adds a log record at the CRITICAL level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function critical(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::CRITICAL, $message, $context);
    }

    /**
     * Adds a log record at the ALERT level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function alert(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::ALERT, $message, $context);
    }

    /**
     * Adds a log record at the EMERGENCY level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function emerg(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::EMERGENCY, $message, $context);
    }

    /**
     * Adds a log record at the EMERGENCY level.
     *
     * @param string $channel The channel name
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function emergency(string $channel, string $message, array $context = []): bool
    {
        return $this->log($channel, Logger::EMERGENCY, $message, $context);
    }
}
