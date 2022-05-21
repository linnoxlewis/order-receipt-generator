<?php

namespace App\Controller;

use App\Helper\ApiResponse;
use App\Manager\Exception\ManagerException;
use App\Manager\Interface\PrinterManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Model\Form\Printer as FormPrinter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for printer.
 *
 * Class PrinterController
 *
 * @package App\Controller
 */
class PrinterController extends BaseApiController
{
    /**
     * Printer manager.
     *
     * @var PrinterManagerInterface
     */
    private PrinterManagerInterface $manager;

    /**
     * Constructor.
     *
     * @param ValidatorInterface $validator
     * @param PrinterManagerInterface $manager
     */
    public function __construct(ValidatorInterface $validator, PrinterManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct($validator);
    }

    /**
     * Endpoint for creating new Printer.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/api/v1/printer", methods={"POST"})
     */
    public function addPrinter(Request $request): JsonResponse
    {
        try {
            $printerForm = new FormPrinter(
                $request->get("name"),
                $request->get("type")
            );
            $this->validate($printerForm);

            $printer = $this->manager->addPrinter(
                $printerForm->name,
                $printerForm->type
            );

            return $this->json(ApiResponse::successResponse([
                "id" => $printer->getId(),
                "apikey" => $printer->getApiKey()
            ]));
        } catch (BadRequestException|ManagerException $ex) {
            return $this->json(ApiResponse::badRequestResponse($ex->getMessage()), 400);
        } catch (Exception $ex) {
            return $this->json(ApiResponse::serverErrorResponse(), 500);
        }
    }

    /**
     * Endpoint for delete Printer.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/api/v1/printer/{id}", methods={"DELETE"})
     */
    public function removerPrinter(Request $request): JsonResponse
    {
        try {
            $id = $request->get("id");
            $this->manager->removePrinter($id);

            return $this->json(ApiResponse::successResponse());
        } catch (ManagerException|BadRequestException $ex) {
            return $this->json(ApiResponse::badRequestResponse($ex->getMessage()), 400);
        } catch (Exception $ex) {
            return $this->json(ApiResponse::serverErrorResponse(), 500);
        }
    }

    /**
     * Endpoint for getting check for complete order.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/api/v1/printer/checks/{id}", methods={"GET"})
     */
    public function checkList(Request $request): JsonResponse
    {
        try {
            $checks = $this->manager->getCompleteChecks($request->get('id'));

            return $this->json(ApiResponse::successResponse($checks));
        } catch (ManagerException|BadRequestException $ex) {
            return $this->json(ApiResponse::badRequestResponse($ex->getMessage()), 400);
        } catch (Exception $ex) {
            return $this->json(ApiResponse::serverErrorResponse(), 500);
        }
    }
}
