<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Included;
use App\Models\LocationType;
use App\Models\LocationTypeVehicle;
use App\Models\Specification;
use App\Models\Vehicle;
use App\Models\VehicleIncluded;
use App\Models\VehicleSpecification;
use App\Models\VehiclesPhotos;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VehiclesExcelImport implements ToCollection, WithMultipleSheets
{
    /**
     * @param Collection $collection
     */

    public $branchId;
    public $supplierId;

    public $vehicleIds = [];

    public $errors = [];

    public function __construct(int $branchId, int $supplierId)
    {
        $this->branchId = $branchId;
        $this->supplierId = $supplierId;
    }

    public function sheets(): array
    {

        return [
            0 => $this,
            1 => $this,
        ];
    }

    public function collection(Collection $collection)
    {
        if (count($this->vehicleIds) == 0)
            $this->vehicleIds = $this->saveVehicles(collect($collection));
        else
            $this->saveIncluded(collect($collection));

        return;
    }

    public function saveVehicles(Collection $collection)
    {
        $vehicleIds = [];

        foreach ($collection as $key => $row) {
            if (is_numeric($row[0])) {
                $vehicle = new Vehicle();
                $vehicle->name = $row[1];
                $vehicle->pickup_loc = $this->branchId;
                $photo = VehiclesPhotos::query()->where('name', 'ilike', '%' . trim($row[1]) . '%')->first();
                if ($photo == null) {
                    $this->errors[] = ['row' => $key + 1, 'error' => 'No Photos for this car found in row number ' . $key + 1];
                }
                $vehicle->photo = $photo ? $photo->photo : null;
                $vehicle->supplier = $this->supplierId;
                $category = Category::query()->where('name', 'ilike', '%' . trim($row[2]) . '%')->first();
                if ($category == null) {
                    $this->errors[] = ['row' => $key + 1, 'error' => 'Category not found in row number ' . $key + 1];
                }
                $vehicle->category = $category ? $category->id : null;

                if ($row[14] == null || $row[14] == '' || $row[14] <= '0') {
                    $this->errors[] = ['row' => $key + 1, 'error' => '1-3 days Price not applicable in row number ' . $key + 1];
                }
                $vehicle->price = $row[14];


                if ($row[15] == null || $row[15] == '' || $row[15] <= '0') {
                    $this->errors[] = ['row' => $key + 1, 'error' => 'Week Price not applicable in row number ' . $key + 1];
                }
                $vehicle->week_price = $row[15];


                if ($row[16] < '0') {
                    $this->errors[] = ['row' => $key + 1, 'error' => 'Week Price not applicable in row number ' . $key + 1];
                }
                $vehicle->month_price = $row[16];

                $vehicle->activation = true;
                $vehicle->instant_confirmation = str_contains(strtolower($row[11]), 'instant') ? 1 : 0;

                if (count($this->errors) > 0) {
                    return $this->errors;
                }

                $vehicle->save();

                $vehicleIds[] = $vehicle->id;


                $airCondition = Specification::query()
                    ->where('name', 'ilike', '%air%')
                    ->first();

                if (!is_null($airCondition) && !is_null($this->findAirCondition(strtolower(trim($row[3]))))) {
                    VehicleSpecification::query()->insert([
                        'vehicle_id' => $vehicle->id,
                        'name' => 'Air Conditioner',
                        'value' => $this->findAirCondition($row[3]),
                        'icon' => $airCondition->icon,
                    ]);
                }

                if (is_numeric($row[4])) {
                    $doors = Specification::query()->where('name', 'ilike', '%door%')->first();
                    if (!is_null($doors)) {
                        VehicleSpecification::query()->insert([
                            'vehicle_id' => $vehicle->id,
                            'name' => 'Doors',
                            'value' => $row[4],
                            'icon' => $doors->icon,
                        ]);
                    }
                }


                if (!is_null($row[5])) {
                    $suitcase = Specification::query()->where('name', 'ilike', '%suitcase%')->first();
                    if (!is_null($suitcase)) {
                        VehicleSpecification::query()->insert([
                            'vehicle_id' => $vehicle->id,
                            'name' => 'Suitcase',
                            'value' => $row[5],
                            'icon' => $suitcase->icon,
                        ]);
                    }

                }

                if (is_numeric($row[6])) {
                    $seats = Specification::query()->where('name', 'ilike', '%seats%')->first();
                    if (!is_null($seats)) {
                        VehicleSpecification::query()->insert([
                            'vehicle_id' => $vehicle->id,
                            'name' => 'Number Of Seats',
                            'value' => $row[6],
                            'icon' => $seats->icon,
                        ]);
                    }
                }

                if (!is_null($row[7])) {
                    $fuel = Specification::query()->where('name', 'ilike', '%fuel%')->first();
                    if (!is_null($fuel)) {
                        VehicleSpecification::query()->insert([
                            'vehicle_id' => $vehicle->id,
                            'name' => 'Fuel',
                            'value' => $row[7],
                            'icon' => $fuel->icon,
                        ]);
                    }
                }

                if (!is_null($row[8])) {
                    $trans = Specification::query()->where('name', 'ilike', '%trans%')->first();
                    if (!is_null($trans)) {
                        VehicleSpecification::query()->insert([
                            'vehicle_id' => $vehicle->id,
                            'name' => $trans->name,
                            'value' => $row[8],
                            'icon' => $trans->icon,
                        ]);
                    }
                }

                $locationType = LocationType::query()->where('name', 'ilike', '%' . strtolower(trim($row[9])) . '%')->first();
                if (!is_null($locationType)) {
                    LocationTypeVehicle::query()->insert([
                        'location_type_id' => $locationType->id,
                        'vehicle_id' => $vehicle->id
                    ]);
                }
            }

        }


        return $vehicleIds;

    }

    public function saveIncluded(Collection $collection)
    {
        dd($collection);

        foreach ($collection as $key => $row) {
            if(!is_null($row[0])){
                $included = new Included();
                $included->what_is_included = $row[0];
                $included->save();
                foreach ($this->vehicleIds as $vehicleId) {
                    VehicleIncluded::query()->insert([
                        'vehicle_id' => $vehicleId,
                        'included_id' => $included->id
                    ]);
                }

            } else {
                break;
            }
        }
    }

    public function findAirCondition($airCondition)
    {
        $airCondition = strtolower($airCondition);

        if (str_contains($airCondition, 'air')) {
            return 'cool & Heat';
        }
        if (str_contains($airCondition, 'condition')) {
            return 'cool & Heat';
        }
        if (str_contains($airCondition, 'ac')) {
            return 'cool & Heat';
        }
        if (str_contains($airCondition, 'a/c')) {
            return 'cool & Heat';
        }
        return null;
    }
}
