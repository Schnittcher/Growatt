<?php

declare(strict_types=1);

require_once __DIR__ . '/../libs/GrowattModBus.php';

    class GrowattTL3X extends GrowattModBus
    {
        const PREFIX = 'GWTL3X';
        public static $Variables = [
            ['Output Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0024, 4, 1,  null, true],
            ['Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0002, 4, 1,  null, true],
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
            ['Total Worktime', VARIABLETYPE_FLOAT, '', 0.5,  0x003A, 4, 1,  null, true],
            ['Inverter Status', VARIABLETYPE_INTEGER, 'Growatt.Status', null,  0x0000, 4, 1,  null, true],
            ['Inverter Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x5D, 4, 1,  null, true],
            ['Active Power Rate', VARIABLETYPE_INTEGER, '~Intensity.100', null,  0x0003, 3, 1,  6, true],
            ['Memory State', VARIABLETYPE_INTEGER, 'Growatt.MemoryState', null,  0x0002, 3, 1,  6, true],
            ['Phase 1 Grid Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0026, 4, 1,  null, true],
            ['Phase 1 Grid Output Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x0027, 4, 1,  null, true],
            ['Phase 2 Grid Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x002A, 4, 1,  null, true],
            ['Phase 2 Grid Output Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x002B, 4, 1,  null, true],
            ['Phase 3 Grid Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x002E, 4, 1,  null, true],
            ['Phase 3 Grid Output Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x002F, 4, 1,  null, true],
            ['L1 L2 Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0032, 4, 1,  null, true],
            ['L2 L3 Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0033, 4, 1,  null, true],
            ['L3 L1 Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0034, 4, 1,  null, true]
        ];

        public function Destroy()
        {
            //Never delete this line!
            parent::Destroy();
        }
    }