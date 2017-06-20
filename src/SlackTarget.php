<?php

namespace alexeevdv\log;

use Maknz\Slack\Client as SlackClient;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\log\Target;

/**
 * Class SlackTarget
 * @package alexeevdv\log
 */
class SlackTarget extends Target
{
    /**
     * @var string
     */
    public $webhook;

    /**
     * :emoji: or URL to image
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $channel;

    /**
     * @var string
     */
    public $username;

    /**
     * @var bool
     */
    public $link_names = false;

    /**
     * @var bool
     */
    public $unfurl_links = false;

    /**
     * @var bool
     */
    public $unfurl_media = true;

    /**
     * @var bool
     */
    public $allow_markdown = true;

    /**
     * @var array
     */
    public $attachmentOptions = [
        'color' => 'danger',
    ];

    /**
     * @var SlackClient
     */
    private $_client;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->webhook) {
            throw new InvalidConfigException('`webhook` is required.');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            $attachment = ArrayHelper::merge(
                $this->attachmentOptions,
                [
                    'text' => $this->formatMessage($message),
                ]
            );
            $this->getClient()->attach($attachment)->send();
        }
    }

    /**
     * @return SlackClient
     */
    private function getClient()
    {
        if (!$this->_client) {
            $this->_client = Yii::createObject(SlackClient::class, [$this->webhook, $this->getOptions()]);
        }
        return $this->_client;
    }

    /**
     * @return array
     */
    private function getOptions()
    {
        $options = [
            'icon' => $this->icon,
            'username' => $this->username,
            'channel' => $this->channel,
            'link_names' => $this->link_names,
            'unfurl_links' => $this->unfurl_links,
            'unfurl_media' => $this->unfurl_media,
            'allow_markdown' => $this->allow_markdown,
        ];
        return array_filter($options, function ($option) {
            return !is_null($option);
        });
    }
}
