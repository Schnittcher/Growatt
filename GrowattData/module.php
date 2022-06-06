<?php

declare(strict_types=1);

if (!function_exists('fnmatch')) {
    define('FNM_PATHNAME', 1);
    define('FNM_NOESCAPE', 2);
    define('FNM_PERIOD', 4);
    define('FNM_CASEFOLD', 16);

    function fnmatch($pattern, $string, $flags = 0)
    {
        return pcre_fnmatch($pattern, $string, $flags);
    }
}

function pcre_fnmatch($pattern, $string, $flags = 0)
{
    $modifiers = null;
    $transforms = [
        '\*'      => '.*',
        '\?'      => '.',
        '\[\!'    => '[^',
        '\['      => '[',
        '\]'      => ']',
        '\.'      => '\.',
        '\\'      => '\\\\'
    ];

    // Forward slash in string must be in pattern:
    if ($flags & FNM_PATHNAME) {
        $transforms['\*'] = '[^/]*';
    }

    // Back slash should not be escaped:
    if ($flags & FNM_NOESCAPE) {
        unset($transforms['\\']);
    }

    // Perform case insensitive match:
    if ($flags & FNM_CASEFOLD) {
        $modifiers .= 'i';
    }

    // Period at start must be the same as pattern:
    if ($flags & FNM_PERIOD) {
        if (strpos($string, '.') === 0 && strpos($pattern, '.') !== 0) {
            return false;
        }
    }

    $pattern = '#^'
        . strtr(preg_quote($pattern, '#'), $transforms)
        . '$#'
        . $modifiers;

    return (boolean) preg_match($pattern, $string);
}

require_once __DIR__ . '/../libs/vendor/SymconModulHelper/VariableProfileHelper.php';

    class GrowattData extends IPSModule
    {
        use VariableProfileHelper;

        public static $Variables = [
            ['epvtotal', 'Total Energy', VARIABLETYPE_FLOAT, '~Electricity', false, true],
            ['pvenergytoday', 'PV Energy Today', VARIABLETYPE_FLOAT, '~Electricity', false, true],
            ['pvenergytotal', 'PV Energy Total', VARIABLETYPE_FLOAT, '~Electricity',  false, true],
            ['epv1today', 'PV 1 Today Energy', VARIABLETYPE_FLOAT, '~Electricity',  false, true],
            ['epv1total', 'PV 1 Total Energy', VARIABLETYPE_FLOAT, '~Electricity',  false, true],
            ['pv1current', 'PV 1 Current', VARIABLETYPE_FLOAT, '~Ampere',  false, true],
            ['pv1voltage', 'PV 1 Voltage', VARIABLETYPE_FLOAT, '~Volt',  false, true],
            ['pv1watt', 'PV 1 Watt', VARIABLETYPE_FLOAT, '~Watt',  false, true],
            ['epv2today', 'PV 2 Today Energy', VARIABLETYPE_FLOAT, '~Electricity',  false, true],
            ['epv2total', 'PV 2 Total Energy ', VARIABLETYPE_FLOAT, '~Electricity', false, true],
            ['pv2current', 'PV 2 Current', VARIABLETYPE_FLOAT, '~Ampere',  false, true],
            ['pv2voltage', 'PV 2 Voltage', VARIABLETYPE_FLOAT, '~Volt',  false, true],
            ['pv2watt', 'PV 2 Watt', VARIABLETYPE_FLOAT, '~Watt',  false, true],
            ['pvfrequentie', 'Grid frequency', VARIABLETYPE_FLOAT, '~Hertz',  false, true],
            ['pvgridcurrent', 'Phase 1 grid current', VARIABLETYPE_FLOAT, '~Ampere', false, true],
            ['pvgridcurrent2', 'Phase 2 grid current', VARIABLETYPE_FLOAT, '~Ampere',  false, true],
            ['pvgridcurrent3', 'Phase 3 grid current', VARIABLETYPE_FLOAT, '~Ampere',  false, true],
            ['pvgridpower', 'Phase 1 grid power', VARIABLETYPE_FLOAT, '~Watt',  false, true],
            ['pvgridpower2', 'Phase 2 grid power', VARIABLETYPE_FLOAT, '~Watt',  false, true],
            ['pvgridpower3', 'Phase 3 grid power', VARIABLETYPE_FLOAT, '~Watt',  false, true],
            ['pvgridvoltage', 'Phase 1 grid voltage', VARIABLETYPE_FLOAT, '~Volt',  false, true],
            ['pvgridvoltage2', 'Phase 2 grid voltage', VARIABLETYPE_FLOAT, '~Volt',  false, true],
            ['pvgridvoltage3', 'Phase 3 grid voltage', VARIABLETYPE_FLOAT, '~Volt',  false, true],
            ['pvipmtemperature', 'IPM inverter temperature', VARIABLETYPE_FLOAT, '~Temperature',  false, true],
            ['pvpowerin', 'Actual input power', VARIABLETYPE_FLOAT, '~Watt',  false, true],
            ['pvpowerout', 'Actual output power', VARIABLETYPE_FLOAT, '~Watt',  false, true],
            ['pvstatus', 'Status', VARIABLETYPE_INTEGER, 'GrowattData.Status', false, true],
            ['pvtemperature', 'Inverter temperature', VARIABLETYPE_FLOAT, '~Temperature', false, true],
            ['totworktime', 'Total Inverter Work Time', VARIABLETYPE_FLOAT, '',  false, true],
            ['uwBatVolt_DSP', 'uwBatVolt_DSP', VARIABLETYPE_FLOAT, '',  false, true],
            ['nbusvolt', 'nbusvolt', VARIABLETYPE_FLOAT, '~Volt',  false, true],
            ['pbusvolt', 'pbusvolt', VARIABLETYPE_FLOAT, '~Volt',  false, true],
            ['Vac_RS', 'Vac_RS', VARIABLETYPE_FLOAT, '',  false, true],
            ['Vac_ST', 'Vac_ST', VARIABLETYPE_FLOAT, '',  false, true],
            ['Vac_TR', 'Vac_TR', VARIABLETYPE_FLOAT, '',  false, true],
            ['pvboottemperature', 'pvboottemperature', VARIABLETYPE_FLOAT, '~Temperature', false, true],
        ];

        public function Create()
        {
            //Never delete this line!
            parent::Create();
            $this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');
            $this->RegisterPropertyString('MQTTTopic', '');
            //protected function RegisterProfileIntegerEx($Name, $Icon, $Prefix, $Suffix, $Associations, $MaxValue = -1, $StepSize=0)

            $this->RegisterProfileIntegerEx(
                'GrowattData.Status',
                'Information',
                '',
                '',
                [
                    [0, $this->Translate('Waiting'), '', -1],
                    [1, $this->Translate('Normal'), '', -1],
                    [2, $this->Translate('Fault'), '', -1],
                ]
            );

            foreach (static::$Variables as $Pos => $Variable) {
                $Variables[] = [
                    'Ident'    => str_replace(' ', '', $Variable[0]),
                    'Name'     => $this->Translate($Variable[1]),
                    'VarType'  => $Variable[2],
                    'Profile'  => $Variable[3],
                    'Action'   => $Variable[4],
                    'Pos'      => $Pos + 1,
                    'Keep'     => $Variable[5]
                ];
            }
            $this->RegisterPropertyString('Variables', json_encode($Variables));
        }

        public function Destroy()
        {
            //Never delete this line!
            parent::Destroy();
        }

        public function ApplyChanges()
        {
            //Never delete this line!
            parent::ApplyChanges();

            $this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');

            $MQTTTopic = $this->ReadPropertyString('MQTTTopic');
            $this->SetReceiveDataFilter('.*' . $MQTTTopic . '.*');
            //Create Variables and check when new Rows in config appear after an update.
            $NewRows = static::$Variables;
            $NewPos = 0;
            $Variables = json_decode($this->ReadPropertyString('Variables'), true);
            foreach ($Variables as $Variable) {
                @$this->MaintainVariable($Variable['Ident'], $Variable['Name'], $Variable['VarType'], $Variable['Profile'], $Variable['Pos'], $Variable['Keep']);
                foreach ($NewRows as $Index => $Row) {
                    if ($Variable['Ident'] == str_replace(' ', '', $Row[0])) {
                        unset($NewRows[$Index]);
                    }
                }
                if ($NewPos < $Variable['Pos']) {
                    $NewPos = $Variable['Pos'];
                }
            }
            if (count($NewRows) != 0) {
                foreach ($NewRows as $NewVariable) {
                    $Variables[] = [
                        'Ident'    => str_replace(' ', '', $NewVariable[0]),
                        'Name'     => $this->Translate($NewVariable[1]),
                        'VarType'  => $NewVariable[2],
                        'Profile'  => $NewVariable[3],
                        'Action'   => $NewVariable[4],
                        'Pos'      => ++$NewPos,
                        'Keep'     => $NewVariable[5]
                    ];
                }
                IPS_SetProperty($this->InstanceID, 'Variables', json_encode($Variables));
                IPS_ApplyChanges($this->InstanceID);
                return;
            }
        }

        public function ReceiveData($JSONString)
        {
            $this->SendDebug('JSON', $JSONString, 0);
            if (!empty($this->ReadPropertyString('MQTTTopic'))) {
                $data = json_decode($JSONString, true);
                if (array_key_exists('Topic', $data)) {
                    if (fnmatch('energy/growatt', $data['Topic'])) {
                        $this->SendDebug('Payload', $data['Payload'], 0);
                        $Payload = json_decode($data['Payload'], true);

                        $this->SetValue('epvtotal', $Payload['values']['epvtotal'] * 0.1);
                        $this->SetValue('pvenergytoday', $Payload['values']['pvenergytoday'] * 0.1);
                        $this->SetValue('pvenergytotal', $Payload['values']['pvenergytotal'] * 0.1);
                        $this->SetValue('epv1today', $Payload['values']['epv1today'] * 0.1);
                        $this->SetValue('epv1total', $Payload['values']['epv1total'] * 0.1);
                        $this->SetValue('pv1current', $Payload['values']['pv1current'] * 0.1);
                        $this->SetValue('pv1voltage', $Payload['values']['pv1voltage'] * 0.1);
                        $this->SetValue('pv1watt', $Payload['values']['pv1watt'] * 0.1);
                        $this->SetValue('epv2today', $Payload['values']['epv2today'] * 0.1);
                        $this->SetValue('epv2total', $Payload['values']['epv2total'] * 0.1);
                        $this->SetValue('pv2current', $Payload['values']['pv2current'] * 0.1);
                        $this->SetValue('pv2voltage', $Payload['values']['pv2voltage'] * 0.1);
                        $this->SetValue('pv2watt', $Payload['values']['pv2watt'] * 0.1);
                        $this->SetValue('pvfrequentie', $Payload['values']['pvfrequentie'] * 0.01);
                        $this->SetValue('pvgridcurrent', $Payload['values']['pvgridcurrent'] * 0.1);
                        $this->SetValue('pvgridcurrent2', $Payload['values']['pvgridcurrent2'] * 0.1);
                        $this->SetValue('pvgridcurrent3', $Payload['values']['pvgridcurrent3'] * 0.1);
                        $this->SetValue('pvgridpower', $Payload['values']['pvgridpower'] * 0.1);
                        $this->SetValue('pvgridpower2', $Payload['values']['pvgridpower2'] * 0.1);
                        $this->SetValue('pvgridpower3', $Payload['values']['pvgridpower3'] * 0.1);
                        $this->SetValue('pvgridvoltage', $Payload['values']['pvgridvoltage'] * 0.1);
                        $this->SetValue('pvgridvoltage2', $Payload['values']['pvgridvoltage2'] * 0.1);
                        $this->SetValue('pvgridvoltage3', $Payload['values']['pvgridvoltage3'] * 0.1);
                        $this->SetValue('pvipmtemperature', $Payload['values']['pvipmtemperature'] * 0.1);
                        $this->SetValue('pvpowerin', $Payload['values']['pvpowerin'] * 0.1);
                        $this->SetValue('pvpowerout', $Payload['values']['pvpowerout'] * 0.1);
                        $this->SetValue('pvstatus', $Payload['values']['pvstatus']);
                        $this->SetValue('pvtemperature', $Payload['values']['pvtemperature'] * 0.1);
                        $this->SetValue('totworktime', $Payload['values']['totworktime'] * 0.5);
                        $this->SetValue('uwBatVolt_DSP', $Payload['values']['uwBatVolt_DSP']);
                        $this->SetValue('nbusvolt', $Payload['values']['nbusvolt']);
                        $this->SetValue('pbusvolt', $Payload['values']['pbusvolt']);
                        $this->SetValue('Vac_RS', $Payload['values']['Vac_RS']);
                        $this->SetValue('Vac_ST', $Payload['values']['Vac_ST']);
                        $this->SetValue('Vac_TR', $Payload['values']['Vac_TR']);
                        $this->SetValue('pvboottemperature', $Payload['values']['pvboottemperature'] * 0.1);
                    }
                }
            }
        }
    }