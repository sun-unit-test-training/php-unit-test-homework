<?php
declare(strict_types=1);

namespace Modules\Exercise08\Tests\Services;

use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use InvalidArgumentException;

class TicketServiceTest extends TestCase
{
    protected $ticketService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketService = new TicketService();
    }

    public function testPriceServiceInTuesday()
    {
        $input = [
            'age' => '18',
            'booking_date' => '05/03/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $result);
    }

    public function testPriceServiceGenderFemaleAndFriday()
    {
        $input = [
            'age' => '18',
            'booking_date' => '05/06/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(TicketService::PRICE_FEMALE_FRIDAY, $result);
    }

    public function testPriceServiceAgeGreaterThan65()
    {
        $input = [
            'age' => '66',
            'booking_date' => '10/06/2022',
            'gender' => 'male',
            'name' => 'Abc',
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(TicketService::PRICE_OVER_65, $result);
    }

    public function testPriceServiceAgeLessThan13()
    {
        $input = [
            'age' => '12',
            'booking_date' => '05/06/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $result);
    }

    public function testBasePriceService()
    {
        $input = [
            'age' => '31',
            'booking_date' => '05/08/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(TicketService::BASE_PRICE, $result);
    }

    public function testCheckAge()
    {
        $this->expectException(InvalidArgumentException::class);
        $inputMinimumAge = [
            'age' => '-1',
            'booking_date' => '05/08/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $resultMinimumAge = $this->ticketService->calculatePrice($inputMinimumAge);

        $this->assertEquals(false, $resultMinimumAge);

        $inputMaximumAge = [
            'age' => '121',
            'booking_date' => '05/08/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $resultMaximumAge = $this->ticketService->calculatePrice($inputMaximumAge);

        $this->assertEquals(false, $resultMaximumAge);
    }

    public function testChooseCheapRate()
    {
        $input = [
            'age' => '12',
            'booking_date' => '05/03/2022',
            'gender' => 'female',
            'name' => 'Abc',
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $result);
    }
}
