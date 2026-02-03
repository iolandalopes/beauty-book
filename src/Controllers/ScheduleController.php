<?php

namespace App\Controllers;

use App\Services\SlotService;
use App\Support\Csrf;
use App\Support\FormValidation;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

class ScheduleController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('schedules/index.html.twig', [
            'user_id' => $request->getQueryParams()['user_id'] ?? null,
            'csrf_token' => Csrf::token(),
        ]);
    }

    public function slots(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getQueryParams();

        $validator = new FormValidation();
        $errors = $validator::validate(
            $data,
            [
                'user_id' => Validator::stringType()
                    ->notEmpty()
                    ->setTemplate('Usuário é obrigatório.'),
                'date' => Validator::date()
                    ->notEmpty()
                    ->setTemplate('Data é obrigatória.'),
            ]
        );


        if (! empty($errors)) {
            return $this->render('schedules/index.html.twig', [
                'user_id' => $request->getQueryParams()['user_id'] ?? null,
                'csrf_token' => Csrf::token(),
                'errors' => $errors,
            ]);
        }

        $userId = (int) $data['user_id'];

        $date = new \DateTime($data['date']);

        $slots = SlotService::generate($userId, $date);

        return $this->render('schedules/index.html.twig', [
            'user_id' => $userId,
            'csrf_token' => Csrf::token(),
            'slots' => $slots,
        ]);
    }
}