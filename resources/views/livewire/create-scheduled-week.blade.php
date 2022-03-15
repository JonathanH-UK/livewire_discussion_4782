<div x-data="{ values: @entangle('values'); errors: @entangle('errors') }">
        {{-- Page content --}}
        <select wire:model="selected_year">
            @foreach( $years as $year )
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>

        <select wire:model="selected_month">
            @foreach( $months as $month )
                <option value="{{ $month }}">{{ $month }}</option>
            @endforeach
        </select>

        <select
            @error('selected_week') style="border-color: red; color: red;" @enderror
        wire:model="selected_week">
            <option value="0">Please select a week...</option>
            @foreach ( $mondays as $date => $monday )
                <option value="{{ $date }}">{{ $monday }}</option>
            @endforeach
        </select>

        <button class="cursor-pointer font-medium border rounded transition duration-200 shadow-sm focus:ring focus:ring-opacity-50 border-transparent bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-200  text-sm py-2 px-4" wire:click="submit">Do it!</button>

        <div class="font-bold text-2xl text-center text-red-800" wire:loading>
            Processing Please Wait...
        </div>

        @foreach($days as $day)
            <h1 class="text-lg font-bold">{{ $day }}</h1>
            <table style="border-spacing: 1rem; border-collapse: separate" id="table-{{$day}}">
                <tr>
                    <th>Room</th>
                    <th>Time</th>
                    <th>Module</th>
                    <th>Trainer</th>
                </tr>
                    @foreach($timeslots as $timeslot_idx => $timeslot)
                        <tr wire:key="{{$day}}.zoom-1.{{ $timeslot_idx  }}">
                            <th class="row-span-2">Account 1</th>
                            <th>{{ $timeslot }}</th>
                            <td>

                                <select @error("values.{$day}.zoom-1.{$timeslot_idx}.module") style="border-color: red; color: red;"
                                        @enderror
                                        wire:model="values.{{$day}}.zoom-1.{{ $timeslot_idx  }}.module" placeholder="Select Module">
                                    <option value="">Not Set...</option>
                                        <option value="1">Module</option>
                                </select>
                            </td>
                            <td>
                                <select @error("values.{$day}.zoom-1.{$timeslot_idx}.trainer") style="border-color: red; color: red;"
                                        @enderror
                                        wire:model="values.{{$day}}.zoom-1.{{ $timeslot_idx }}.trainer" placeholder="Select Trainer">
                                    <option value="">Not Set...</option>
                                        <option value="1">Trainer 1</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
</div>
