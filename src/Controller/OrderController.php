<?php

namespace App\Controller;

use App\Helper\ApiResponse;
use App\Manager\Exception\ManagerException;
use App\Manager\Interface\OrderManagerInterface;
use App\Model\Form\Order;
use App\Model\Form\OrderList;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Controller for order
 *
 * Class OrderController
 *
 * @package App\Controller
 */
class OrderController extends BaseApiController
{
    /**
     * Order manager
     *
     * @var OrderManagerInterface
     */
    private OrderManagerInterface $manager;

    /**
     * OrderController constructor.
     *
     * @param ValidatorInterface $validator
     * @param OrderManagerInterface $manager
     */
    public function __construct(ValidatorInterface $validator, OrderManagerInterface $manager)
    {
        parent::__construct($validator);
        $this->manager = $manager;
    }

    /**
     * Endpoint for get orders list
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/api/v1/order/list", methods={"GET"})
     */
    public function getOrderList(Request $request): JsonResponse
    {
        try {
            $form = new OrderList(
                $request->get("printerId"),
                $request->get("page"),
                $request->get("limit"),
            );
            $this->validate($form);

            $list = $this->manager->getOrderList(
                $form->getPrinterId(),
                $form->getPage(),
                $form->getLimit(),
            );


            return $this->json(ApiResponse::successResponse($list));
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
            return $this->json(ApiResponse::serverErrorResponse(), 500);
        }
    }

    /**
     * Endpoint for creating new Printer
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/api/v1/order", methods={"POST"})
     */
    public function createOder(Request $request): JsonResponse
    {
        try {
            $form = new Order(
                $request->get("printerId"),
                $request->get("info"),
                $request->get("amount"),
            );
            $this->validate($form);

            $order = $this->manager->createOrder(
                $form->getInfo(),
                $form->getAmount(),
                $form->getPrinterId()
            );

            return $this->json(ApiResponse::successResponse([
                "id" => $order->getId(),
            ]));
        } catch (ManagerException $ex) {
            return $this->json(ApiResponse::badRequestResponse($ex->getMessage()), 400);
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
            return $this->json(ApiResponse::serverErrorResponse(), 500);
        }
    }
}
