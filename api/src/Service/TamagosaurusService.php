<?php

namespace App\Service;

use App\Entity\Tamagosaurus;
use App\Repository\TamagosaurusRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TamagosaurusService
{
    public function __construct(
        private TamagosaurusRepository $tamagosaurusRepository,
    ) { }

    public function checkStatus(Tamagosaurus $tamagosaurus): void
    {
        $timeNow = new \DateTime();

        $this->checkHunger($tamagosaurus, $timeNow);
        $this->checkStroll($tamagosaurus, $timeNow);
    }

    private function checkHunger(Tamagosaurus $tamagosaurus, \DateTime $timeReference): void
    {
        $lastFed = $tamagosaurus->getLastFed() ?? $tamagosaurus->getCreatedAt();
        $foodInterval = $tamagosaurus->getType()->getFoodInterval();

        if (!$foodInterval) {
            return;
        }

        $expectedFeeding = $lastFed->add($foodInterval);
        if ($expectedFeeding < $timeReference) {
            $hunger = max($tamagosaurus->getHunger() - 1, 0);

            $tamagosaurus->setHunger($hunger);
            $this->tamagosaurusRepository->save($tamagosaurus, true);

            // $this->throwConflict("Time to feed!");
        }
        // mettre en place le timer

        // dd($expectedFeeding, $foodInterval, $timeReference);
    }

    private function checkStroll(Tamagosaurus $tamagosaurus, \DateTime $timeReference): void
    {
        $lastWentOut = $tamagosaurus->getLastWentOut() ?? $tamagosaurus->getCreatedAt();
        $strollInterval = $tamagosaurus->getType()->getStrollInterval();

        if (!$strollInterval) {
            return;
        }
    }

    private function throwConflict(string $message)
    {
        throw new HttpException(Response::HTTP_CONFLICT, $message);
    }
}