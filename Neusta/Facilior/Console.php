<?php
/**
 * Created by PhpStorm.
 * User: nlotzer
 * Date: 03.02.2016
 * Time: 08:17
 */

namespace Neusta\Facilior;


use Neusta\Facilior\Console\ConsoleOutputInterface;
use Neusta\Facilior\Console\Kernel;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Console
{
    /**
     * @var Kernel|null
     */
    protected $kernel = null;

    /**
     * @var null|Application
     */
    protected $application = null;

    /**
     * @var null|ConsoleOutputInterface
     */
    protected $console = null;


    /**
     * Console constructor.
     */
    public function __construct()
    {
        $this->kernel = new Kernel();
        $this->application = new Application('Neusta Facilior', FACILIOR_VERSION);

        //Creates Console Output
        $this->console = new ConsoleOutputInterface();

        //Loads Commands into Application
        $this->application->addCommands($this->kernel->commands());
    }

    /**
     * Main function of Facilior
     * @param null $arguments
     * @return int
     */
    public function execute($arguments = null)
    {
        //Defining internal variables
        $exitCode = 0;

        //Greetings
        $this->console->output('Welcome to <fg=cyan>Facilior</>', 0, 2);
        $this->console->log('Logging started');
        $this->console->output('<fg=default;options=bold>Logging started:</> <fg=magenta>' . $this->console->getLogFile() . '</>', 1, 2);

        //Run Command and check if there is a config error
        $argumentsInput = new ArrayInput($arguments);
        $this->application->run($argumentsInput, $this->console->getConsoleOutput());

        //Bye, Bye
        $this->console->output('Finished <fg=cyan>Facilior</>', 0, 2);
        return $exitCode;
    }



    /**
     * Overrides symfonys default commands
     * @return void
     */
    protected function applyApplicationConfiguration()
    {
        $this->application->setDefaultCommand('');
        $this->application->setCatchExceptions(false);
    }

}