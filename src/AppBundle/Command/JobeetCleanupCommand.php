<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JobeetCleanupCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('jobeet:cleanup')
            ->setDescription('Cleanup jobeet database')
            ->addArgument('days', InputArgument::OPTIONAL, 'jobs older than x days', 90)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $days = $input->getArgument('days');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $nb = $em->getRepository('AppBundle:Job')->cleanup($days);

        $output->writeln(sprintf('Removed %d stale jobs', $nb));
    }
}