<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\Availability;
use App\Support\Csrf;
use App\Support\FormValidation;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

class AvailabilityController extends BaseController
{
    private Availability $availability;

    public function __construct()
    {
        parent::__construct();
        $this->availability = new Availability();
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        AuthMiddleware::handle();

        $userId = $_SESSION['auth']['id'];
        $availabilities = $this->availability->allByUser($userId);

        return $this->render('availabilities/index.html.twig', [
            'availabilities' => $availabilities,
            'csrf_token' => Csrf::token(),
        ]);
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        AuthMiddleware::handle();

        return $this->render('availabilities/form.html.twig', [
            'csrf_token' => Csrf::token(),
        ]);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        AuthMiddleware::handle();
        $data = $request->getParsedBody();
        Csrf::validate($data['_csrf'] ?? null);

        $data = [
            'weekday'       => (int)$data['weekday'] ?? '',
            'start_time'    => $data['start_time'] ?? '',
            'end_time'      => $data['end_time'] ?? '',
            'slot_duration' => (int)$data['slot_duration'] ?? '',
        ];

        $userId = $_SESSION['auth']['id'];

        if ($this->availability->hasConflict(
            $userId,
            (int)$data['weekday'],
            $data['start_time'],
            $data['end_time']
        )) {
            return $this->render(
                '/availabilities/form.html.twig',
                [
                    'errors' => 'Já existe um horário cadastrado nesse período.'
                ]
            );
        }

        $validator = new FormValidation();
        $errors = $validator::validate(
            $data,
            [
                'weekday' => Validator::intType()
                    ->between(0, 6)
                    ->setTemplate('O dia da semana deve ser um número entre 0 (domingo) e 6 (sábado).'),
                'start_time' => Validator::regex('/^(2[0-3]|[01][0-9]):([0-5][0-9])$/')
                    ->setTemplate('O horário de início deve estar no formato HH:MM (24 horas).'),
                'end_time' => Validator::regex('/^(2[0-3]|[01][0-9]):([0-5][0-9])$/')
                    ->setTemplate('O horário de fim deve estar no formato HH:MM (24 horas).'),
                'slot_duration' => Validator::intType()
                    ->positive()
                    ->notEmpty()
                    ->setTemplate('A duração do intervalo deve ser um número positivo.'),
                '_time_range' => Validator::callback(
                        function () use ($data) {
                            return $data['start_time'] < $data['end_time'];
                        }
                )->setTemplate('O horário de início deve ser antes do horário de fim.'),
            ]
        );

        if (! empty($errors)) {
            return $this->render('availabilities/form.html.twig', [
                'errors' => $errors,
                'data' => $data,
            ]);
        }

        $this->availability->store([
            'user_id' => $userId,
            ...$data,
        ]);

        return new RedirectResponse('/availabilities');
    }

    public function destroy(ServerRequestInterface $request): ResponseInterface
    {
        AuthMiddleware::handle();

        $data = $request->getParsedBody();
        Csrf::validate($data['_csrf'] ?? null);

        $this->availability->delete($request->getAttribute('id'));

        return new RedirectResponse('/availabilities');
    }

    public function edit(ServerRequestInterface $request): ResponseInterface
    {
        AuthMiddleware::handle();

        $id = $request->getAttribute('id');
        $availability = $this->availability->find($id);

        return $this->render('availabilities/form.html.twig', [
            'availability' => $availability,
            'isEdit' => true,
            'csrf_token' => Csrf::token(),
        ]);
    }

    public function update(ServerRequestInterface $request, array $id): ResponseInterface
    {
        AuthMiddleware::handle();

        $data = $request->getParsedBody();
        Csrf::validate($data['_csrf'] ?? null);

        $this->availability->find($id['id']);
        unset($data['_method']);
        unset($data['_csrf']);

        $this->availability->update($data, $id['id']);

        return new RedirectResponse('/availabilities');
    }
}