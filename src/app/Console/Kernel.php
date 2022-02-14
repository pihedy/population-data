<?php declare(strict_types=1);

namespace App\Console;

/** 
 * Kernel that runs commands on the app.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
final class Kernel
{
    /**
     * An array of key objects for commands that can be called through the console.
     * 
     * @var array
     */
    public $commands = [
        'cmd:population' => \App\Console\Command\PopulationCommand::class
    ];

    /**
     * Another raw version of incoming commands.
     * 
     * @var array
     */
    private $argv;

    /**
     * A variable required for parsing.
     * 
     * @var array
     */
    private $parsed;

    /**
     * The called command.
     * 
     * @var null|string
     */
    private $command = null;

    /**
     * Arguments to the command.
     * 
     * @var array
     */
    private $arguments = [];

    /**
     * @param array|null $argv 
     */
    public function __construct(array $argv = null)
    {
        if ($argv === null) {
            $argv = $_SERVER['argv'];
        }

        array_shift($argv);

        $this->argv = $argv;

        $this->parse();
    }

    /**
     * Processing the obtained parameters.
     */
    public function parse(): void
    {
        $this->parsed = $this->argv;

        while (($arg = array_shift($this->parsed)) !== null) {
            preg_match('/cmd:/', $arg, $output);

            if (is_array($output) && !empty($output)) {
                $this->command = $arg;
            }

            if (strpos($arg, '--') === 0) {
                $this->parseArgument($arg);
            }
        }
    }

    /**
     * The operator function responsible for running commands.
     * 
     * @return string 
     * 
     * @throws \Exception If no command is found in the call.
     * @throws \Exception If the specified command is not found.
     * @throws \Exception If the class for the command is not the correct type.
     */
    public function handle(): string
    {
        try {
            if ($this->command === null) {
                throw new \Exception(
                    'At least the command is required!'
                );
            }
    
            if (!array_key_exists($this->command, $this->commands)) {
                throw new \Exception(
                    sprintf(
                        'The %s does not exist between the commands.', 
                        $this->command
                    )
                );
            }
    
            $Command = new $this->commands[$this->command]($this->arguments);
    
            /* if (!$Command instanceof Command) {
                throw new \Exception('The command can only be of type Command!');
            } */
    
            return sprintf("%s\r\n", $Command->run());
        } catch (\Exception $e) {
            return sprintf("%s\r\n", $e->getMessage());
        }
    }

    /**
     * It processes long plus arguments.
     * 
     * @param string $arg 
     */
    private function parseArgument(string $arg): void
    {
        $name = substr($arg, 2);

        if (($pos = strpos($name, '=')) === false) {
            return;
        }

        if ((strlen($value = substr($name, $pos + 1))) === 0) {
            array_unshift($this->parsed, null);
        }

        $key                        = substr($name, 0, $pos);
        $this->arguments[$key]      = $value;
    }
}
