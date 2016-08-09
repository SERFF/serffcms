<?php
namespace Serff\Cms\Core\Console;


use Illuminate\Console\Command;
use Illuminate\Console\Events\ArtisanStarting;

class Kernel extends \App\Console\Kernel
{

    /**
     * Add custom console command to jobs
     *
     * @param $command
     */
    public function addCommand($command)
    {
        /**
         * @var Command $command
         */
        $command = new $command();
        $command_name = $this->commandNameToCommandString($command->getName());
        $this->app[ $command_name ] = $this->app->share(
            function ($app) use ($command) {
                return $command;
            }
        );

        $this->commands($command_name);
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function commandNameToCommandString($name)
    {
        return 'command.' . str_replace(':', '.', $name);
    }

    /**
     * Register the package's custom Artisan commands.
     *
     * @param  array|mixed $commands
     *
     * @return void
     */
    public function commands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        // To register the commands with Artisan, we will grab each of the arguments
        // passed into the method and listen for Artisan "start" event which will
        // give us the Artisan console instance which we will give commands to.
        $events = $this->app['events'];

        $events->listen(ArtisanStarting::class, function ($event) use ($commands) {
            $event->artisan->resolveCommands($commands);
        });
    }


}