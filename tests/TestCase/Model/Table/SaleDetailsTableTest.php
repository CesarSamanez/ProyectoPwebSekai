<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SaleDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SaleDetailsTable Test Case
 */
class SaleDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SaleDetailsTable
     */
    public $SaleDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SaleDetails',
        'app.Articles',
        'app.Sales'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SaleDetails') ? [] : ['className' => SaleDetailsTable::class];
        $this->SaleDetails = TableRegistry::getTableLocator()->get('SaleDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SaleDetails);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
