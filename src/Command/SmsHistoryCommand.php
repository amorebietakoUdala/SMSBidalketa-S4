<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Command;

use AmorebietakoUdala\SMSServiceBundle\Controller\SmsApi;
use App\Entity\History;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of SmsHistoryDaemonCommand.
 *
 * @author ibilbao
 */
class SmsHistoryCommand extends Command
{
    protected static $defaultName = 'app:sms-history';

    private $em;
    private $smsApi;

    public function __construct(EntityManagerInterface $em, SmsApi $smsApi)
    {
        $this->em = $em;
        $this->smsApi = $smsApi;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Gets the last History messages from SMS provider API and stores them in the database.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Gets the last History messages from SMS provider API and stores them in the database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getHistory($output);
    }

    private function getHistory(OutputInterface $output)
    {
        $histories = [];
        $start = 0;
        $end = 200;
        $found = false;

        $lastHistory = $this->em->getRepository(History::class)->findOneBy([], ['id' => 'desc'], 1);
        if (null === $lastHistory) {
            $lastHistory = null;
        }
        try {
            $api_histories = $this->smsApi->getHistory($start, $end);
            $firstResult = $api_histories->{'data'}[0];
            if (null === $lastHistory) {
                $lastId = 0;
            } else {
                $lastId = $lastHistory->getId();
            }
            if ($firstResult->{'id'} === $lastId) {
                return 0;
            }
            foreach ($api_histories->{'data'} as $record) {
                if ($record->{'id'} > $lastId) {
                    $history = new History($record);
                    $histories[] = $history;
                    $this->em->persist($history);
                    $found = true;
                }
            }
            if ($found) {
                $this->em->flush();
            }
        } catch (Exception $e) {
            $output->writeln('<error>ERROR: '.$e->getMessage().'</error>');
        }

        return $histories;
    }
}
