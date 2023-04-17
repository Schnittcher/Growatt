<?php

declare(strict_types=1);

eval('declare(strict_types=1);namespace Growatt {?>' . file_get_contents(__DIR__ . '/../libs/vendor/SymconModulHelper/SemaphoreHelper.php') . '}');
eval('declare(strict_types=1);namespace Growatt {?>' . file_get_contents(__DIR__ . '/../libs/vendor/SymconModulHelper/VariableProfileHelper.php') . '}');

class GrowattModBus extends IPSModule
{
    use Growatt\Semaphore;
    use Growatt\VariableProfileHelper;
    const Swap = false;

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        $this->ConnectParent('{A5F663AB-C400-4FE5-B207-4D67CC030564}');
        $this->RegisterPropertyInteger('Interval', 0);
        $this->RegisterProfileIntegerEx(
            'Growatt.Status',
            'Information',
            '',
            '',
            [
                [0, $this->Translate('Waiting'), '', -1],
                [1, $this->Translate('Normal'), '', -1],
                [2, $this->Translate('Fault'), '', -1],
            ]
        );

        $this->RegisterProfileIntegerEx(
            'Growatt.MemoryState',
            'Information',
            '',
            '',
            [
                [1, $this->Translate('Active'), '', -1],
                [0, $this->Translate('Inactive'), '', -1],
                [65535, $this->Translate('-'), '', -1],
            ]
        );

        foreach (static::$Variables as $Pos => $Variable) {
            $Variables[] = [
                'Ident'     => str_replace(' ', '', $Variable[0]),
                'Name'      => $this->Translate($Variable[0]),
                'VarType'   => $Variable[1],
                'Profile'   => $Variable[2],
                'Factor'    => $Variable[3],
                'Address'   => $Variable[4],
                'Function'  => $Variable[5],
                'Quantity'  => $Variable[6],
                'FunctionW' => $Variable[7],
                'Pos'       => $Pos + 1,
                'Keep'      => $Variable[8]
            ];
        }
        $this->RegisterPropertyString('Variables', json_encode($Variables));
        $this->RegisterTimer('UpdateTimer', 0, static::PREFIX . '_RequestRead($_IPS["TARGET"]);');
    }

    public function resetVariables()
    {
        $NewRows = static::$Variables;
        $Variables = [];
        foreach ($NewRows as $Pos => $Variable) {
            $Variables[] = [
                'Ident'     => str_replace(' ', '', $Variable[0]),
                'Name'      => $this->Translate($Variable[0]),
                'VarType'   => $Variable[1],
                'Profile'   => $Variable[2],
                'Factor'    => $Variable[3],
                'Address'   => $Variable[4],
                'Function'  => $Variable[5],
                'Quantity'  => $Variable[6],
                'FunctionW' => $Variable[7],
                'Pos'       => $Pos + 1,
                'Keep'      => $Variable[8]
            ];
        }
        IPS_SetProperty($this->InstanceID, 'Variables', json_encode($Variables));
        IPS_ApplyChanges($this->InstanceID);
        return;
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();

        $this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');

        //Create Variables and check when new Rows in config appear after an update.
        $NewRows = static::$Variables;
        $this->SendDebug('Info :: New Rows', count($NewRows), 0);
        $NewPos = 0;
        $Variables = json_decode($this->ReadPropertyString('Variables'), true);
        foreach ($Variables as $Variable) {
            @$this->MaintainVariable($Variable['Ident'], $Variable['Name'], $Variable['VarType'], $Variable['Profile'], $Variable['Pos'], $Variable['Keep']);
            if (($Variable['FunctionW'] != null) && ($Variable['Keep'])) {
                $this->EnableAction($Variable['Ident']);
            }
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
                    'Ident'     => str_replace(' ', '', $NewVariable[0]),
                    'Name'      => $this->Translate($NewVariable[0]),
                    'VarType'   => $NewVariable[1],
                    'Profile'   => $NewVariable[2],
                    'Factor'    => $NewVariable[3],
                    'Address'   => $NewVariable[4],
                    'Function'  => $NewVariable[5],
                    'Quantity'  => $NewVariable[6],
                    'FunctionW' => $NewVariable[7],
                    'Pos'       => ++$NewPos,
                    'Keep'      => $NewVariable[8]
                ];
            }
            IPS_SetProperty($this->InstanceID, 'Variables', json_encode($Variables));
            IPS_ApplyChanges($this->InstanceID);
            return;
        }
        if ($this->ReadPropertyInteger('Interval') > 0) {
            $this->SetTimerInterval('UpdateTimer', $this->ReadPropertyInteger('Interval'));
        } else {
            $this->SetTimerInterval('UpdateTimer', 0);
        }
    }

    public function RequestRead()
    {
        $Gateway = IPS_GetInstance($this->InstanceID)['ConnectionID'];
        if ($Gateway == 0) {
            return false;
        }
        $IO = IPS_GetInstance($Gateway)['ConnectionID'];
        if ($IO == 0) {
            return false;
        }
        if (!$this->lock($IO)) {
            return false;
        }
        $Result = $this->ReadData();
        IPS_Sleep(333);
        $this->unlock($IO);
        return $Result;
    }

    public function RequestAction($Ident, $Value)
    {
        $Variables = json_decode($this->ReadPropertyString('Variables'), true);
        foreach ($Variables as $Variable) {
            if ($Variable['Ident'] == $Ident) {
                $this->WriteData($Variable, $Value);
            }
        }
    }

    public function GetConfigurationForm()
    {
        $Form = json_decode(file_get_contents(__DIR__ . '/form.json'), true);
        $Form['actions'][0]['onClick'] = static::PREFIX . '_RequestRead($id);';
        if (count(static::$Variables) == 1) {
            unset($Form['elements'][1]);
        }
        return json_encode($Form);
    }

    protected function SetValueExt($Variable, $Value)
    {
        $id = @$this->GetIDForIdent($Variable['Ident']);
        if ($id == false) {
            $this->MaintainVariable($Variable['Ident'], $Variable['Name'], $Variable['VarType'], $Variable['Profile'], $Variable['Pos'], $Variable['Keep']);
        }

        if ($Variable['Factor'] != null) {
            $Value = $Value * $Variable['Factor'];
        }

        $this->SetValue($Variable['Ident'], $Value);
        return true;
    }

    protected function ModulErrorHandler($errno, $errstr)
    {
        $this->SendDebug('ERROR', utf8_decode($errstr), 0);
        echo $errstr;
    }

    private function WriteData($Variable, $Value)
    {
        $SendData['DataID'] = '{E310B701-4AE7-458E-B618-EC13A1A6F6A8}';
        $SendData['Function'] = $Variable['FunctionW'];
        $SendData['Address'] = $Variable['Address'];
        $SendData['Quantity'] = $Variable['Quantity'];

        switch ($Variable['VarType']) {
            case VARIABLETYPE_INTEGER:
                switch ($Variable['Quantity']) {
                    case 1:
                        $SendData['Data'] = pack('n', $Value);
                }
                break;
            case VARIABLETYPE_FLOAT:
                switch ($Variable['Quantity']) {
                    case 1:
                        $SendData['Data'] = pack('n', $Value);
                }
                break;
        }
        set_error_handler([$this, 'ModulErrorHandler']);
        $ReadData = $this->SendDataToParent(json_encode($SendData));
        restore_error_handler();
        $this->RequestRead();
    }

    private function ReadData()
    {
        $Variables = json_decode($this->ReadPropertyString('Variables'), true);
        foreach ($Variables as $Variable) {
            if (!$Variable['Keep']) {
                continue;
            }
            $SendData['DataID'] = '{E310B701-4AE7-458E-B618-EC13A1A6F6A8}';
            $SendData['Function'] = $Variable['Function'];
            $SendData['Address'] = $Variable['Address'];
            $SendData['Quantity'] = $Variable['Quantity'];
            $SendData['Data'] = '';

            set_error_handler([$this, 'ModulErrorHandler']);
            $ReadData = $this->SendDataToParent(json_encode($SendData));
            restore_error_handler();
            if ($ReadData === false) {
                return false;
            }
            $ReadValue = substr($ReadData, 2);
            $this->SendDebug($Variable['Name'] . ' RAW', $ReadValue, 1);
            if (static::Swap) {
                $ReadValue = strrev($ReadValue);
            }
            $Value = $this->ConvertValue($Variable, $ReadValue);
            if ($Value === null) {
                $this->LogMessage(sprintf($this->Translate('Combination of type and size of value (%s) not supported.'), $Variable['Name']), KL_ERROR);
                continue;
            }
            $this->SendDebug($Variable['Name'], $Value, 0);
            $this->SetValueExt($Variable, $Value);
        }
        return true;
    }

    private function ConvertValue(array $Variable, string $Value)
    {
        switch ($Variable['VarType']) {
            case VARIABLETYPE_BOOLEAN:
                if ($Variable['Quantity'] == 1) {
                    return ord($Value) == 0x01;
                }
                break;
            case VARIABLETYPE_INTEGER:
                switch ($Variable['Quantity']) {
                    case 1:
                        return unpack('n', $Value)[1];
                    case 2:
                        return unpack('n*', $Value)[1];
                }
                break;
            case VARIABLETYPE_FLOAT:
                switch ($Variable['Quantity']) {
                    case 1:
                        return unpack('n', $Value)[1];
                    case 2:
                        return unpack('n*', $Value)[1];
                }
                break;
            case VARIABLETYPE_STRING:
                return $Value;
        }
        return null;
    }
}

