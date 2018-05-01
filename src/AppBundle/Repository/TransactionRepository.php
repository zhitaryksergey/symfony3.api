<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Transaction;

/**
 * TransactionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TransactionRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Find sum of approved transactions grouped by email for current month
     * @return mixed
     */
    public function findAllForCurrentMonth()
    {
        $queryBuilder = $this->createQueryBuilder('t');

        $and = $queryBuilder->expr()->andX();
        $and->add($queryBuilder->expr()->eq('t.status', ":status"));
        $and->add($queryBuilder->expr()->eq('MONTH(t.datetime)', 'MONTH(CURRENT_DATE())'));

        $query = $queryBuilder->select([
            't.email',
            'SUM(t.amount) as sum',
            'MONTH(t.datetime) as month'
        ])
            ->where($and)
            ->setParameter('status', Transaction::APPROVED)
            ->groupBy('t.email, month')
            ->getQuery();

        return $query->execute();
    }

    /**
     * Find sum of approved transactions grouped by email for current week
     * @return array
     */
    public function findAllForLastWeek()
    {
        $queryBuilder = $this->createQueryBuilder('t');

        $and = $queryBuilder->expr()->andX();
        $and->add($queryBuilder->expr()->eq('t.status', ":status"));
        $and->add($queryBuilder->expr()->between('DATE(t.datetime)', ":dateStart", ":dateEnd"));

        $query = $queryBuilder->select([
            't.email',
            'SUM(t.amount) as sum',
            'DATE(t.datetime) as date',
        ])
            ->where($and)
            ->setParameter('status', Transaction::APPROVED)
            ->setParameter('dateStart', (new \DateTime())->modify('monday this week')->format('Y/m/d')) // setup range for this week
            ->setParameter('dateEnd', (new \DateTime())->modify('sundays this week')->format('Y/m/d'))
            ->groupBy('t.email, date')
            ->getQuery();

        // get all week days
        $timestamp = strtotime('next Monday');
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $days[] = strftime('%A', $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }

        $result = [];
        $transactions = $query->execute();
        foreach ($transactions as $transaction) {
            $result[$transaction['email']][(new \DateTime($transaction['date']))->format('l')] = $transaction['sum'];
        }

        foreach ($result as $key => &$item) {
            foreach ($days as $day) {
                if (!isset($item[$day])) {
                    $item[$day] = 0;
                }
            }
        }

        return ['users' => $result, 'days' => $days];
    }
}