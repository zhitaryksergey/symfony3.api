<?php

namespace AppBundle\Controller;

use AppBundle\Repository\TransactionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var TransactionRepository $transactions */
        $transactions = $this->getDoctrine()->getRepository('AppBundle:Transaction');

        $transactionsForLastWeek = $transactions->findAllForLastWeek();
        $transactionsForCurrentMonth = $transactions->findAllForCurrentMonth();

        $response = $this->render('default/index.html.twig',
            [
                'transactions_for_current_month' => $transactionsForCurrentMonth,
                'transactions_for_last_7_days' => $transactionsForLastWeek['users'],
                'week_days' => $transactionsForLastWeek['days'],
            ]
        );

        $response->headers->set('Content-Type', 'text/html; charset=UTF-8'); // todo: hard code

        return $response;
    }
}
