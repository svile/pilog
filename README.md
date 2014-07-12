# Pilog

A simple PHP logging system which is PSR-3 and PSR-4 compliable.

## Installation via Composer

Simply add a dependency on `svile/pilog` to your project's `composer.json` file if you use [Composer](http://getcomposer.org/) to manage the dependencies of your project. Here is a minimal example of a `composer.json` file that just defines a development-time dependency on Pilog:

    {
        "require": {
            "svile/pilog": "*"
        }
    }

## Usage

### Global

In order to use the global logger, you'll need to set it up first. However, non of the settings below are mandatory. If you skip the set function, the default log level will be set. If you skip the output, then nothing will be written anywhere and no exceptions will be thrown.

    // Set the log level. Blank function call yields LogLevel::DEBUG
    Svile\Pilog\Log::set(LogLevel::ERROR);
    // Set the output. -> /path/to/file/mainlog.log
    Svile\Pilog\Log::setOutput(new File('/path/to/file', 'mainlog'));
    
After you've set it up, you can call it from anywhere within your application

    Svile\Pilog\Log::error('Something went terribly wrong');
    
### Local

Very similar the global usage, where all the settings and default values apply, except you'll need to instantiate the class here

    // Set the log level. Blank function call yields LogLevel::DEBUG
    $logger = new  Svile\Pilog\Logger(LogLevel::INFO);
    $logger->setOutput(new File('/path/to/file', 'mainlog'));
    // it is time to move on
    $logger->notice('Start coding');
