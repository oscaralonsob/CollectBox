<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Acceptance;

use Behat\MinkExtension\Context\MinkContext;

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
     * @Then /^the response is:$/
     */
    public function thenTheResponseIs(string $text)
    {
        $actualResponse = json_decode($this->getSession()->getPage()->getContent());
        $expectedResponse = json_decode($text);

        \PHPUnit\Framework\Assert::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @Then /^404 is returned/
     */
    public function then404IsReturned()
    {
        \PHPUnit\Framework\Assert::assertEquals(404, $this->getSession()->getStatusCode());
    }
}