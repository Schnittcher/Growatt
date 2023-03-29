<?php

declare(strict_types=1);

require_once __DIR__ . '/../libs/GrowattModBus.php';

    class GrowattTL3BHUP extends GrowattModBus
    {
        const PREFIX = 'GWTL3BHUP';
        public static $Variables = [
            ['Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0002, 4, 1,  null, true],
            ['Input Power (high)', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0001, 4, 1,  null, true],
            ['Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0038, 4, 1,  null, true],
            ['Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0036, 4, 1,  null, true],
            ['Grid frequency', VARIABLETYPE_FLOAT, '~Hertz', 0.01,  0x0025, 4, 1,  null, true],
            ['PV1 Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x003E, 4, 1,  null, true],
            ['PV1 Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x003C, 4, 1,  null, true],
            ['PV1 Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0006, 4, 1,  null, true],
            ['PV1 Input Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x0004, 4, 1,  null, true],
            ['PV1 Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0003, 4, 1,  null, true],
            ['PV2 Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0042, 4, 1,  null, true],
            ['PV2 Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0040, 4, 1,  null, true],
            ['PV2 Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x000A, 4, 1,  null, true],
            ['PV2 Input Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x0008, 4, 1,  null, true],
            ['PV2 Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0007, 4, 1,  null, true],
            ['Inverter Boost Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x005F, 4, 1,  null, true],
            ['Inverter IPM Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x005E, 4, 1,  null, true],
            ['Inverter Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x5D, 4, 1,  null, true],
            ['Active Power Rate', VARIABLETYPE_INTEGER, '~Intensity.100', null,  0x0003, 3, 1,  6, true],
            ['Memory State', VARIABLETYPE_INTEGER, 'Growatt.MemoryState', null,  0x0002, 3, 1,  6, true],
            ['Phase 1 Grid Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0026, 4, 1,  null, true],
            ['Phase 1 Grid Output Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x0027, 4, 1,  null, true],
            ['Phase 2 Grid Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x002A, 4, 1,  null, true],
            ['Phase 2 Grid Output Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x002B, 4, 1,  null, true],
            ['Phase 3 Grid Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x002E, 4, 1,  null, true],
            ['Phase 3 Grid Output Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x002F, 4, 1,  null, true],
            ['Current electricity consumption', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x040E, 4, 1,  null, true],
            ['Total electricity from grid', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0417, 4, 1,  null, true],
            ['Total power consumption', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0427, 4, 1,  null, true],
            ['Battery State', VARIABLETYPE_INTEGER, '~Intensity.100', null,  0x03F6, 4, 1,  null, true],
            ['AC power to grid', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0400, 4, 1,  null, true],
            ['AC power to grid (High)', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03FF, 4, 1,  null, true],
            ['AC power to user', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03FE, 4, 1,  null, true],
            ['AC power to user (High)', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03FD, 4, 1,  null, true],
            ['Battery Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x0410, 4, 1,  null, true],
            ['PV Electric Energy Today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x047E, 4, 1,  null, true],
            ['Energy to Grid total', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x041B, 4, 1,  null, true],
            ['Energy to Grid today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0419, 4, 1,  null, true],
            ['Energy to User today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0415, 4, 1,  null, true],
            ['Charge power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03F4, 4, 1,  null, true],
            ['Discharge power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03F2, 4, 1,  null, true],
            ['Self electric Energy Today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0476, 4, 1,  null, true],
            ['Self electric Energy total', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0478, 4, 1,  null, true],
            ['Eigenverbrauch Heute', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0476, 4, 1,  null, true]
        ];

        public function Destroy()
        {
            //Never delete this line!
            parent::Destroy();
        }
    }