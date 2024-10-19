<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Acceptance;

use Behat\MinkExtension\Context\MinkContext;

use function PHPUnit\Framework\assertEquals;

class ApiContext extends MinkContext
{
    /**
     * @When I visit :arg1
     */
    public function whenIVisit(string $arg1)
    {
        $this->visit($arg1);
    }

    /**
     * @Then /^the response is "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function thenTheResponseIs(string $text)
    {
        $response = json_decode($this->getSession()->getPage()->getContent());
        assertEquals($response->msg, $text);
    }
}