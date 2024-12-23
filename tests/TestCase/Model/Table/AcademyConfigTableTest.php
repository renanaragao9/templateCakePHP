<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AcademyConfigTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AcademyConfigTable Test Case
 */
class AcademyConfigTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AcademyConfigTable
     */
    protected $AcademyConfig;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AcademyConfig',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AcademyConfig') ? [] : ['className' => AcademyConfigTable::class];
        $this->AcademyConfig = $this->getTableLocator()->get('AcademyConfig', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AcademyConfig);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AcademyConfigTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
