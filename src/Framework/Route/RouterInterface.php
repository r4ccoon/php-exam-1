<?php

namespace Rpl\Framework\Route;

use Klein\Request;
use Klein\Response;

interface RouterInterface
{
    public function getMethods(): array;

    public function getHandledRoute(): string;

    public function handle(Request $request, Response $response): void;
}
