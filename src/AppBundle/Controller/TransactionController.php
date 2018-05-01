<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Transaction;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TransactionController extends FOSRestController
{
    private $_status = [
        'rejected' => [
            'multiple' => true,
            'type' => [
                'Fraud detected! 1',
                'Fraud detected! 2',
                'Fraud detected! 3',
                'Fraud detected! 4'
            ]
        ],
        'approved' => [
            'multiple' => false,
            'type' => 'Transaction accept'
        ]
    ];

    /**
     * Randomly generate status
     * @return mixed
     */
    private function _generateStatus()
    {
        $status = array_rand($this->_status, 1);
        $responseStatus['status'] = $status;
        if ($this->_status[$status]['multiple']) {
            $types = $this->_status[$status]['type'];
            $type = array_rand($types, 1);
            $responseStatus['type'] = $types[$type];
        } else {
            $responseStatus['type'] = $this->_status[$status]['type'];
        }

        return $responseStatus;
    }

    /**
     * @Rest\Post("/transaction/{email}/{amount}/")
     * @param string $email
     * @param float $amount
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return View
     */
    public function postAction($email, $amount, Request $request, ValidatorInterface $validator)
    {
        $transaction = new Transaction();

        $datetime = new \DateTime("now");

        $statusData = $this->_generateStatus();
        $status = $statusData['status'];

        if ($status == Transaction::APPROVED) {
            $token = md5($email . time());
            $transaction->setToken($token);
            $responseData = [
                'status' => $status,
                'transaction_token' => $token
            ];
        } else {
            $responseData = [
                'status' => $status,
                'error_message' => $statusData['type']
            ];
        }

        $transaction->setEmail($email);
        $transaction->setAmount($amount);
        $transaction->setStatus($status);
        $transaction->setDatetime($datetime);

        /** @var ConstraintViolationListInterface $errors */
        $errors = $validator->validate($transaction);
        if (count($errors) > 0) {
            $validationErrors = [
                'status' => 'Validation Errors',
                'errors' => []
            ];
            /** @var ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $validationErrors['errors'][$error->getPropertyPath()] = $error->getMessage();
            }

            return new View($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($transaction);
        $em->flush();

        return new View($responseData, Response::HTTP_OK);
    }
}
