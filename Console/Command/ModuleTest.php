<?php

namespace Gundo\ProductInfoAgent\Console\Command;

use Gundo\ProductInfoAgent\Model\CollectionFactory;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleTest extends Command
{
    private CollectionFactory $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct();
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('agent:product:into:test')
            ->setDescription('Test Insert Command for ProductInfoAgent');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Prepare data for inserting matching the ProductInfoAgent model
        $data = [
            'message' => 'Test message',
            'user_id' => 1,
            'model' => 'Test model',
            // Automatically handled by the model
        ];

        // Create the collection
        $collection = $this->collectionFactory->create();

        try {

            $item = $collection->getbyId(1);

            $output->writeln('Inserted Product ID: ');
            $output->writeln(' Message: ' . $item->getMessage());
            $output->writeln(' User: '. $item->getUserId());
        } catch (\Exception $e) {
            $output->writeln('<error>Error inserting item: ' . $e->getMessage() . '</error>');
            return Cli::RETURN_FAILURE; // Return failure code
        }

        return Cli::RETURN_SUCCESS; // Return success code
    }
}
