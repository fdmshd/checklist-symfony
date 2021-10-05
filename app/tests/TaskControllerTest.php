<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testGetTaskList(): void
    {
        $data[] = $this->getTask1();
        $data[] = $this->getTask2();
        $expectedData = array(
            "data" => $data
        );
        $expectedJson = json_encode($expectedData);

        $client = static::createClient();
        $client->request('GET', '/tasks');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseJson = $response->getContent();
        $this->assertJsonStringEqualsJsonString($expectedJson, $responseJson);
    }

    public function testGetTask(): void
    {
        $data = $this->getTask1();
        $expectedData = array(
            "data" => $data
        );
        $expectedJson = json_encode($expectedData);

        $client = static::createClient();
        $client->request('GET', '/tasks/1');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseJson = $response->getContent();

        $this->assertJsonStringEqualsJsonString($expectedJson, $responseJson);
    }

    public function testChangeCompletionMark(): void
    {
        $client = static::createClient();
        $client->request('POST', '/tasks/1');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson);
        $this->assertTrue($responseData->data->isDone);
    }

    public function testDeleteTask(): void
    {
        $expectedData = array(
            "message" => "task successfully removed"
        );
        $expectedJson = json_encode($expectedData);
        $client = static::createClient();
        $client->request('DELETE', '/tasks/2');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson);
        $this->assertJsonStringEqualsJsonString($expectedJson, $responseJson);
    }

    public function testUpdateTask(): void
    {
        $body = array(
            "title" => "updatedTestTitle1",
            "description" => "testDescription1"
        );
        $data = $this->getTask1();
        $data["title"] = "updatedTestTitle1";
        $expectedData = array(
            "message" => "task successfully updated",
            "data" => $data
        );
        $expectedJson = json_encode($expectedData);

        $client = static::createClient();
        $client->request('PUT', '/tasks/1', [], [], [], json_encode($body));
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseJson = $response->getContent();

        $this->assertJsonStringEqualsJsonString($expectedJson, $responseJson);
    }

    public function testCreateTask(): void
    {
        $body = array(
            "title" => "createdTestTitle",
            "description" => "createdTestDescription"
        );
        $client = static::createClient();
        $client->request('POST', '/tasks', [], [], [], json_encode($body));
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson);
        $this->assertSame($responseData->data->title, $body["title"]);
        $this->assertSame($responseData->data->description, $body["description"]);
        $this->assertSame($responseData->message, "task successfully created");
    }

    private function getTask1(): array
    {
        return array(
            "id" => 1,
            "title" => 'testTitle1',
            "description" => 'testDescription1',
            "creationTimestamp" => '2021-09-30T08:39:16+00:00',
            "completionTimestamp" => null,
            "isDone" => false
        );
    }

    private function getTask2(): array
    {
        return array(
            "id" => 2,
            "title" => 'testTitle2',
            "description" => 'testDescription2',
            "creationTimestamp" => '2021-09-30T08:39:16+00:00',
            "completionTimestamp" => null,
            "isDone" => false
        );
    }
}
