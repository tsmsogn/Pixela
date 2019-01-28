<?php

namespace Pixela\Test;

use Pixela\Api\Graphs;
use Pixela\Client;

class GraphsTest extends PixelaTestCase
{
    /**
     * @var \Pixela\ClientInterface
     */
    public $client;

    /**
     * @var \Pixela\Api\User
     */
    public $user;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->client = new Client(self::USERNAME, self::TOKEN);
        $this->user = $this->client->api('User');
        $this->user->create();
    }

    protected function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub

        $this->user->delete();
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCRUD()
    {
        /** @var \Pixela\Api\Graphs $graph */
        $graph = $this->client->api('Graphs');

        $graph->setId('test-graph')
            ->setName('graph-name')
            ->setUnit('commit')
            ->setType('int')
            ->setColor('shibafu');

        // Create graph
        $this->assertTrue($graph->create());

        // Test
        $graphs = $graph->get();
        $this->assertCount(1, $graphs);
        $this->assertEquals($graph, $graphs[0]);
        $this->assertRegExp('/^<svg/', $graph->getSVG());
        $this->assertEquals('https://pixe.la/v1/users/tsmsogn-ghost/graphs/test-graph.html', $graph->getURL());

        // Update graph
        $graph->setName('new-test-graph')
            ->setUnit('calory')
            ->setColor('momiji')
            ->setTimezone('UTC')
            ->setPurgeCacheURLs(array(
                'https://camo.githubusercontent.com/xxx/xxxx'
            ));
        $this->assertTrue($graph->update());

        // Test
        $graphs = $graph->get();
        $this->assertCount(1, $graphs);
        $this->assertEquals($graph, $graphs[0]);

        // Delete graph
        $this->assertTrue($graph->delete());

        // Test
        $graphs = $graph->get();
        $this->assertCount(0, $graphs);
    }
}