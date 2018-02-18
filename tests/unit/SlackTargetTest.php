<?php

namespace tests\unit;

use alexeevdv\log\SlackTarget;
use Codeception\Stub;
use Yii;
use yii\base\InvalidConfigException;
use yii\log\Logger;

/**
 * Class SlackTargetTest
 * @package tests\unit
 */
class SlackTargetTest extends \Codeception\Test\Unit
{
    /**
     * @var \tests\UnitTester
     */
    public $tester;

    /**
     * @test
     */
    public function init()
    {
        // check that webhook is required
        $this->tester->expectException(InvalidConfigException::class, function () {
            new SlackTarget;
        });

        new SlackTarget([
            'webhook' => 'https://web.hook',
        ]);
    }

    /**
     * @test
     */
    public function export()
    {
        Yii::$container->setSingleton(\Maknz\Slack\Client::class, function () {
            return Stub::make(\Maknz\Slack\Client::class, [
                'createMessage' => function () {
                    return Stub::make(\Maknz\Slack\Message::class, [
                        'send' => function () {
                        },
                    ]);
                }
            ]);
        });

        $target = new SlackTarget([
            'webhook' => 'https://web.hook',
        ]);

        $target->messages[] = [
            'Some sh*t happened!',
            Logger::LEVEL_ERROR,
            'slack',
            time()
        ];

        $target->export();
    }
}
