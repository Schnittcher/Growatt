<?php

declare(strict_types=1);

require_once __DIR__ . '/../libs/GrowattModBus.php';

    class GrowattTL3BHUP extends GrowattModBus
    {
        const PREFIX = 'GWTL3BHUP';
        public static $Variables = [
            ['Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0001, 4, 2,  null, true],
            ['Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0037, 4, 2,  null, true],
            ['Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0035, 4, 2,  null, true],
            ['Grid frequency', VARIABLETYPE_FLOAT, '~Hertz', 0.01,  0x0025, 4, 1,  null, true],
            ['PV1 Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x003D, 4, 2,  null, true],
            ['PV1 Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x003B, 4, 2,  null, true],
            ['PV1 Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0005, 4, 2,  null, true],
            ['PV1 Input Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x0004, 4, 1,  null, true],
            ['PV1 Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0003, 4, 1,  null, true],
            ['PV2 Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0041, 4, 2,  null, true],
            ['PV2 Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x003F, 4, 2,  null, true],
            ['PV2 Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0009, 4, 2,  null, true],
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
            ['Current electricity consumption', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x040D, 4, 2,  null, true],
            ['Total electricity from grid', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0416, 4, 2,  null, true],
            ['Total power consumption', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0426, 4, 2,  null, true],
            ['Battery State', VARIABLETYPE_INTEGER, '~Intensity.100', null,  0x03F6, 4, 1,  null, true],
            ['AC power to grid', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03FF, 4, 2,  null, true],
            ['AC power to user', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03FD, 4, 2,  null, true],
            ['Battery Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x0410, 4, 1,  null, true],
            ['PV Electric Energy Today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x047D, 4, 2,  null, true],
            ['Energy to Grid total', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x041A, 4, 2,  null, true],
            ['Energy to Grid today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0418, 4, 2,  null, true],
            ['Energy to User today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0414, 4, 2,  null, true],
            ['Charge power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03F3, 4, 2,  null, true],
            ['Discharge power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x03F1, 4, 2,  null, true],
            ['Self electric Energy Today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0475, 4, 2,  null, true],
            ['Self electric Energy total', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0477, 4, 2,  null, true],
            ['Discharge Energy1 today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x041C, 4, 2,  null, true],
            ['Total discharge Energy1', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x041E, 4, 2,  null, true],
            ['Charge1 Energy today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0420, 4, 2,  null, true],
            ['Charge1 Energy total', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0422, 4, 2,  null, true],
            ['Local load Energy today', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0424, 4, 2,  null, true],
            ['Local load Energy total', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x0426, 4, 2,  null, true]
        ];

        public function Destroy()
        {
            //Never delete this line!
            parent::Destroy();
        }
    }