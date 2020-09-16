<?php

namespace Modules\Exercise10\Services;

use Modules\Exercise10\Contracts\Services\PrepaidInterface;
use Modules\Exercise10\Contracts\Repositories\CardLevelRepository;

class PrepaidCardService implements PrepaidInterface
{
    protected $repository;

    public function __construct(CardLevelRepository $repo)
    {
        $this->repository = $repo;
    }

    public function getAmountBonus(array $data): array
    {
        $type = (int) $data['type'] ?? null;
        $price = (int) $data['price'] ?? 0;
        $ballot = (bool) $data['ballot'] ?? false;

        $results = [
            'type' => $type,
            'price' => $price,
            'ballot' => $ballot,
            'bonus' => 0,
            'amount' => $price,
        ];

        if ($ballot) {
            $item = $this->repository->findBonus($type, $price);
            if ($item) {
                $bonus = $item->bonus;
                $results['bonus'] = $price * $bonus / 100;
                $results['amount'] = $price * abs(100 - $bonus) / 100;
            }
        }

        return $results;
    }
}
