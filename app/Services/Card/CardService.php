<?php

namespace App\Services\Card;

use App\Exceptions\CardNotFoundException;
use App\Repositories\Card\Contracts\CardRepositoryInterface;

class CardService implements CardServiceInterface
{
    public function __construct(private CardRepositoryInterface $cardRepository)
    {
    }

    public function validate(string $cardNumber): array
    {
        $card = $this->cardRepository->firstWhere(['public_number' => $cardNumber]);
        if (!$card) {
            throw new CardNotFoundException();
        }

        return $card;
    }
}
