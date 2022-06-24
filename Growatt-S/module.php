<?php

declare(strict_types=1);

require_once __DIR__ . '/../libs/GrowattModBus.php';

    class GrowattS extends GrowattModBus
    {
        const PREFIX = 'GWS';

        public static $Variables = [
            ['Output Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x000C, 4, 1,  null, true],
            ['Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0002, 4, 1,  null, true],
            ['Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x001D, 4, 1,  null, true],
            ['Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x001B, 4, 1,  null, true],
            ['Grid frequency', VARIABLETYPE_FLOAT, '~Hertz', 0.01,  0x000D, 4, 1,  null, true],
            //['PV1 Total Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x003E, 4, 1,  null, true],
            //['PV1 Today Energy', VARIABLETYPE_FLOAT, '~Electricity', 0.1,  0x003C, 4, 1,  null, true],
            ['PV1 Input Power', VARIABLETYPE_FLOAT, '~Watt', 0.1,  0x0006, 4, 1,  null, true],
            ['PV1 Input Current', VARIABLETYPE_FLOAT, '~Ampere', 0.1,  0x0004, 4, 1,  null, true],
            ['PV1 Voltage', VARIABLETYPE_FLOAT, '~Volt', 0.1,  0x0003, 4, 1,  null, true],
            ['Inverter IPM Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x0029, 4, 1,  null, true],
            ['Total Worktime', VARIABLETYPE_FLOAT, '', 0.5,  0x001F, 4, 1,  null, true],
            ['Inverter Status', VARIABLETYPE_INTEGER, 'Growatt.Status', null,  0x0000, 4, 1,  null, true],
            ['Inverter Temperature', VARIABLETYPE_FLOAT, '~Temperature', 0.1,  0x0020, 4, 1,  null, true],
            ['Active Power Rate', VARIABLETYPE_INTEGER, '~Intensity.100', null,  0x0003, 3, 1,  6, true],
            ['Memory State', VARIABLETYPE_INTEGER, 'Growatt.MemoryState', null,  0x0002, 3, 1,  6, true]
        ];

        public function Destroy()
        {
            //Never delete this line!
            parent::Destroy();
        }
    }