<?php

namespace App\Command;

use App\Service\ImportProduct;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class WarehouseImportCommand
 * @package App\Command
 */
class WarehouseImportCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'warehouse:import';

    /**
     * @var ImportProduct
     */
    protected $importProduct;


    /**
     * WarehouseImportCommand constructor.
     * @param null $name
     * @param ImportProduct $importProduct
     */
    public function __construct($name = null, ImportProduct $importProduct)
    {
        $this->importProduct = $importProduct;

        parent::__construct($name);
    }

    /**
     * Configure
     */
    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->importProduct->importNewCollection()) {
            $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        } else {
            $io->error('Something wrong with import!');
        }
    }
}
