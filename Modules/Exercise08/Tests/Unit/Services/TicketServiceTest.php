<?php

namespace Modules\Exercise08\Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise08\Services\TicketService;

class TicketServiceTest extends TestCase {

    protected $ticketService;
    protected $monday;
    protected $tuesday;
    protected $friday;

    public function setUp(): void
    {
        parent::setUp();
        $this->ticketService = new TicketService;
        $this->monday = Carbon::parse('first monday of this month')->format('m/d/Y');
        $this->tuesday = Carbon::parse('first tuesday of this month')->format('m/d/Y');
        $this->friday = Carbon::parse('first friday of this month')->format('m/d/Y');
    }

    public function test_male_12y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 12,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE * 0.5, $fee);
    }

    public function test_male_13y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 13,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE, $fee);
    }

    public function test_male_12y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 12,
            'booking_date' => $this->tuesday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE * 0.5, $fee);
    }

    public function test_male_13y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 13,
            'booking_date' => $this->tuesday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $fee);
    }

    public function test_male_65y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 65,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE, $fee);
    }

    public function test_male_66y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 66,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_OVER_65, $fee);
    }

    public function test_male_65y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 65,
            'booking_date' => $this->tuesday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $fee);
    }

    public function test_male_66y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 66,
            'booking_date' => $this->tuesday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $fee);
    }

    public function test_male_12y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 12,
            'booking_date' => $this->friday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE * 0.5, $fee);
    }

    public function test_male_13y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 13,
            'booking_date' => $this->friday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE, $fee);
    }

    public function test_male_65y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 65,
            'booking_date' => $this->friday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE, $fee);
    }

    public function test_male_66y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 66,
            'booking_date' => $this->friday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_OVER_65, $fee);
    }

    public function test_female_12y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 12,
            'booking_date' => $this->monday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE * 0.5, $fee);
    }

    public function test_female_13y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 13,
            'booking_date' => $this->monday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE, $fee);
    }

    public function test_female_12y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 12,
            'booking_date' => $this->tuesday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE * 0.5, $fee);
    }

    public function test_female_13y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 13,
            'booking_date' => $this->tuesday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $fee);
    }

    public function test_female_65y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 65,
            'booking_date' => $this->monday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE, $fee);
    }

    public function test_female_66y_old_on_monday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 66,
            'booking_date' => $this->monday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_OVER_65, $fee);
    }

    public function test_female_65y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 65,
            'booking_date' => $this->tuesday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $fee);
    }

    public function test_female_66y_old_on_tuesday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 66,
            'booking_date' => $this->tuesday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $fee);
    }

    public function test_female_12y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 12,
            'booking_date' => $this->friday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE * 0.5, $fee);
    }

    public function test_female_13y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 13,
            'booking_date' => $this->friday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_FEMALE_FRIDAY, $fee);
    }

    public function test_female_65y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 65,
            'booking_date' => $this->friday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_FEMALE_FRIDAY, $fee);
    }

    public function test_female_66y_old_on_friday()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 66,
            'booking_date' => $this->friday,
            'gender' => 'female',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_FEMALE_FRIDAY, $fee);
    }

    public function test_age_less_than_min()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The age must be from 0 to 120');

        $input = [
            'name' => 'My Name is Hieu',
            'age' => -1,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $this->ticketService->calculatePrice($input);
    }

    public function test_age_min()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 0,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::BASE_PRICE * 0.5, $fee);
    }

    public function test_age_max()
    {
        $input = [
            'name' => 'My Name is Hieu',
            'age' => 120,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $fee = $this->ticketService->calculatePrice($input);
        $this->assertEquals(TicketService::PRICE_OVER_65, $fee);
    }

    public function test_age_greater_than_max()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The age must be from 0 to 120');

        $input = [
            'name' => 'My Name is Hieu',
            'age' => 121,
            'booking_date' => $this->monday,
            'gender' => 'male',
        ];

        $this->ticketService->calculatePrice($input);
    }
}
