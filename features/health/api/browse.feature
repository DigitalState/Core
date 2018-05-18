@component @api @health @browse
Feature: Browse health statuses
  In order to browse health statuses
  As a system identity
  I should be able to send api requests related to health statuses

  Background:
    Given I am authenticated as the "System" identity from the tenant "b6ac25fe-3cd6-4100-a054-6bba2fc9ef18"

  @createSchema @loadFixtures @dropSchema
  Scenario: Browse all health statuses
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/health"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json"
    And the response should be in JSON
