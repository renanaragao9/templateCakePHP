<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CollaboratorsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CollaboratorsTable Test Case
 */
class CollaboratorsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CollaboratorsTable
     */
    protected $Collaborators;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Collaborators',
        'app.Users',
        'app.Events',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Collaborators') ? [] : ['className' => CollaboratorsTable::class];
        $this->Collaborators = $this->getTableLocator()->get('Collaborators', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Collaborators);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CollaboratorsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CollaboratorsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
