<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class CreateScheduledWeek extends Component
{

    public $years;
    public $months;
    public $mondays;
    public $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
    public $timeslots = [
        'morning' => '09:15',
        'afternoon' => '13:15'];
    public $selected_year;
    public $selected_month;
    public $selected_week = '0';
    public $zoom_accounts = [[ 'id' => '1', 'account_name' => 'Test']];
    public $trainers = [['id' => '1', 'name' => 'Trainer']];
    public $modules = [[ 'id' => '1', 'title' => 'Module 1' ]];

    public $values = [];

    public function rules() {
        $rules['selected_week'] = 'required|not_in:0,null';
        foreach($this->values as $day => $rooms) {
            foreach ($rooms as $room => $timeslots) {
                foreach ($timeslots as $timeslot => $entries ) {
                    if ( array_key_exists('module',$entries) && $entries['module'] > 0 ) {
                        $rules["values.$day.$room.$timeslot.trainer"] = 'required|not_in:0';
                    }
                    if ( array_key_exists('trainer',$entries) && $entries['trainer'] > 0 ) {
                        $rules["values.$day.$room.$timeslot.module"] = 'required|not_in:0';
                    }
                }
            }
        }
        return $rules;
    }

    public function updated($propertyName)
    {
        \Log::warning($propertyName);
        if ( preg_match('/\.module$/',$propertyName) !== false ) {
            $trainer = preg_replace('/\.module$/', '.trainer', $propertyName);
            \Log::warning("Trainer $trainer");
            $this->validateOnly($trainer);
        }
        if ( preg_match('/\.trainer$/',$propertyName) !== false ) {
            $module = preg_replace('/\.trainer$/', '.module', $propertyName);
            \Log::warning("Module $module");
            $this->validateOnly($module);
        }
        $this->validateOnly($propertyName);
    }

    public function updateMondays() {
        $monday_month =  new \DatePeriod(
            Carbon::parse("first monday of " . $this->selected_month. " " . $this->selected_year),
            CarbonInterval::week(),
            Carbon::parse("first monday of " . $this->selected_month. " " . $this->selected_year . " next month"),
        );
        $this->mondays = [];
        foreach($monday_month as $monday) {
//            dd($monday->diffInDays(Carbon::now()));
//            dd($monday);
            if ( $monday->diffInDays(Carbon::now(),false) <= 0 ) {
                $this->mondays[$monday->format('Y-m-d')] = $monday->format('l jS');
            }
        }
    }

    public function render()
    {
        $this->updateMondays();
        return view('livewire.create-scheduled-week');
    }

        public function mount()
        {
            $now = Carbon::today();

            $this->selected_year = $now->format('Y');
            $this->selected_month = $now->format('F');
            $this->years = [];
            $this->years[] = $now->format('Y');
            for ($i = 0; $i < 3; $i++) {
                $this->years[] = $now->addYears(1)->format('Y');
            }

            $this->months = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December',
            ];

            $this->updateMondays();

        }
}
