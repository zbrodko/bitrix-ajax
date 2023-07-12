<?php
//local/components/machaon/feedback/class.php

namespace Machaon\Components;

use Bitrix\Main\Error;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Contract\Controllerable;
use CBitrixComponent;

class FeedbackComponent extends CBitrixComponent implements Controllerable, Errorable
{
    protected ErrorCollection $errorCollection;

    public function onPrepareComponentParams($arParams)
    {
        $this->errorCollection = new ErrorCollection();
        return $arParams;
    }

    public function executeComponent()
    {
        // Метод не будет вызван при ajax запросе
    }

    public function getErrors(): array
    {
        return $this->errorCollection->toArray();
    }

    public function getErrorByCode($code): Error
    {
        return $this->errorCollection->getErrorByCode($code);
    }

    // Описываем действия
    public function configureActions(): array
    {
        return [
            'send' => [
                'prefilters' => [
                    // здесь указываются опциональные фильтры, например:
                    new ActionFilter\Authentication(), // проверяет авторизован ли пользователь
                ]
            ]
        ];
    }

    // Сюда передаются параметры из ajax запроса, навания точно такие же как и при отправке запроса.
    // $_REQUEST['username'] будет передан в $username, $_REQUEST['email'] будет передан в $email и т.д.
    public function sendAction(string $username = '', string $email = '', string $message = ''): array
    {
        try {
            $this->doSomeWork();
            return [
                "result" => "Ваше сообщение принято",
            ];
        } catch (Exceptions\EmptyEmail $e) {
            $this->errorCollection[] = new Error($e->getMessage());
            return [
                "result" => "Произошла ошибка",
            ];
        }
    }
}