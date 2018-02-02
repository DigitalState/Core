@component @entity @config @browse
Feature: Browse configs
  In order to browse configs
  As a system identity
  I should be able to send api requests related to configs

  Background:
    Given I am authenticated as the "system" identity

  @createSchema @loadFixtures @dropSchema
  Scenario: Browse all permissions
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/configs"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
