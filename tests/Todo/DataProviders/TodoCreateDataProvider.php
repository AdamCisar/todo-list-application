<?php declare(strict_types=1);

namespace Tests\Todo\DataProviders;

class TodoCreateDataProvider
{
    public static function invalidTodoPayloadProvider(): array
    {
        return [
            'missing title' => [[]],
            'empty title' => [['title' => '']],
            'title not string' => [['title' => 123]],
            'title too long' => [['title' => str_repeat('a', 256)]],
        ];
    }
}
