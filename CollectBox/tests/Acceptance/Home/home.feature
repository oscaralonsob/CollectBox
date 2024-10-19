Feature: Home context check
    Scenario: It receives a response
        When I visit "/"
        Then the response is "Hello"
