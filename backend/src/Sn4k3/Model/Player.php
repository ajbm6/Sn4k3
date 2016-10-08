<?php

namespace Sn4k3\Model;

use Sn4k3\Behaviour\DestroyableInterface;
use Sn4k3\Behaviour\DestroyableTrait;

class Player implements DestroyableInterface
{
    use DestroyableTrait;

    const DIRECTION_LEFT = 'left';
    const DIRECTION_RIGHT = 'right';

    const DEFAULT_TICK_INTERVAL = 10;

    const AVAILABLE_COLORS = [
        0,
        1,
        2,
        3
    ];

    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $color;

    /**
     * @var Snake
     */
    public $snake;

    /**
     * @var int
     */
    public $score = 0;

    /**
     * @var bool
     */
    public $keyPressed = false;

    /**
     * In degree.
     *
     * @var int
     */
    public $angleIntervalOnTick;

    /**
     * @var Map
     */
    public $map;

    public function __construct(Map $map, int $angleIntervalOnTick = self::DEFAULT_TICK_INTERVAL)
    {
        $this->map = $map;
        $this->angleIntervalOnTick = $angleIntervalOnTick;
        $this->snake = new Snake($map, $this);
        $this->color = self::AVAILABLE_COLORS[array_rand(self::AVAILABLE_COLORS)];

        $map->snakes[] = $this->snake;
    }

    /**
     * @param $direction
     *
     * @return bool
     */
    public function canChangeDirection($direction)
    {
        switch ($direction) {
            case self::DIRECTION_LEFT:
                return $this->snake->direction !== self::DIRECTION_RIGHT;

            case self::DIRECTION_RIGHT:
                return $this->snake->direction !== self::DIRECTION_LEFT;

            default:
                return false;
        }
    }

    /**
     * @param string $direction
     */
    public function changeDirection(string $direction)
    {
        if ($this->canChangeDirection($direction)) {
            $this->snake->direction = $direction;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getVarsToDestroy(): array
    {
        return [
            $this->snake,
        ];
    }
}
