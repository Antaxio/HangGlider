<?php

namespace Antaksio\HandGlider\instance;

use pocketmine\entity\effect\EffectInstance;

class CustomEffectInstance extends EffectInstance
{
    private int $amplifier;

    public function getAmplifier(): int
    {
        return $this->amplifier;
    }

    public function setAmplifier(int $amplifier): EffectInstance
    {
        $this->amplifier = $amplifier;
        return $this;
    }

}