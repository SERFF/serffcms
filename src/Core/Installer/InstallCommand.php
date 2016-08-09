<?php
namespace Serff\Cms\Core\Installer;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'cms:install';

    /**
     * @var string
     */
    protected $description = 'Run the installation of the CMS';

    /**
     *
     */
    public function handle()
    {
        $installer = app(Installer::class);

        $installer->install();
        
        $this->comment(PHP_EOL . 'Installation is done' . PHP_EOL);
    }
}