<?php

namespace App\Providers;

use App\Exceptions\ValidationException;
use Exception;

class ValidationProvider
{
    private $status   = false;
    private $messages = [];

    private static $_status   = false;
    private static $_messages = [];

    const VALIDATION = [
        "required"   => [self::class, 'validationRequired'],
        "length"     => [self::class, 'validationLength'],
        "length_max" => [self::class, 'validationLengthMax'],
        "length_min" => [self::class, 'validationLengthMin'],
        "count_max"  => [self::class, 'validationCountMax'],
        "count_min"  => [self::class, 'validationCountMin'],
        "number"     => [self::class, "validationNumber"],
        "bool"       => [self::class, "validaitonBool"],
        "email"      => [self::class, "validationEmail"]
    ];

    public function __construct($status = false, $messages = [])
    {
        $this->status   = $status;
        $this->messages = $messages;
    }

    public static function validation(array &$data, array $validate, bool $exception = true)
    {
        self::$_status   = false;
        self::$_messages = [];

        foreach ($validate as $campo => $validations) {
            foreach ($validations as $validation) {
                if (is_callable($validation)) {
                    $result = call_user_func(
                        $validation,
                        $campo,
                        $data
                    );

                    if ($result !== true) {
                        self::addMessageErro($campo, $result);
                    }
                    
                    break;
                }

                $validation = self::getParametersValition($validation);

                if (array_key_exists($validation[0], self::VALIDATION)) {
                    call_user_func(
                        self::VALIDATION[$validation[0]],
                        $campo,
                        $data,
                        $validation
                    );
                }
            }
        }

        if ($exception && count(self::$_messages) > 0) {
            throw new ValidationException(self::$_messages);
        }

        return new self(self::$_status, self::$_messages);
    }

    private static function validationRequired(string $index, array $data)
    {
        if (!array_key_exists($index, $data)) {
            self::addMessageErro($index, "O campo {$index} é obrigatorio");
        } else {
            if (is_string($data[$index])) {
                if (empty($data[$index])) {
                    self::addMessageErro($index, "O campo {$index} é obrigatorio");
                }
            }
        }
    }

    private static function validationEmail(string $index, array $data)
    {
        if (array_key_exists($index, $data)) {
            if (!filter_var($data[$index], FILTER_VALIDATE_EMAIL)) {
                self::addMessageErro(
                    $index,
                    "O campo {$index} não é um email valido"
                );
            }
        }
    }

    private static function validaitonBool(string $index, array $data)
    {
        if (array_key_exists($index, $data)) {
            $value = $data[$index];
            $bools = ["1", "0", "on", "off", "true", "false"];

            if (is_bool($value)) {
                return;
            }

            if (array_search($value, $bools) === false) { 
                self::addMessageErro(
                    $index,
                    "O campo {$index} não é um valor de confirmação"
                );
            }
        }
    }

    private static function validationNumber(string $index, array $data)
    {
        if (array_key_exists($index, $data)) {
            if (!is_numeric($data[$index])) {
                self::addMessageErro(
                    $index,
                    "O campo {$index} não é um valor númerico"
                );
            }
        }
    }

    private static function validationLength(string $index, array $data, array $params)
    {
        if (count($params) !== 2) {
            throw new Exception("Parametros invalidos de validação");
        }

        if (array_key_exists($index, $data)) {
            if (strlen($data[$index]) !== $params[1]) {
                self::addMessageErro(
                    $index,
                    "O campo {$index} deve conter {$params[1]} caracteres"
                );
            }
        }
    }

    private static function validationLengthMax(string $index, array $data, array $params)
    {
        if (count($params) !== 2) {
            throw new Exception("Parametros invalidos de validação");
        }

        if (array_key_exists($index, $data)) {
            if (strlen($data[$index]) > $params[1]) {
                self::addMessageErro(
                    $index,
                    "O campo {$index} não deve ser maior que {$params[1]} caracteres"
                );
            }
        }
    }

    private static function validationLengthMin(string $index, array $data, array $params)
    {
        if (count($params) !== 2) {
            throw new Exception("Parametros invalidos de validação");
        }

        if (array_key_exists($index, $data)) {
            if (strlen($data[$index]) < $params[1]) {
                self::addMessageErro(
                    $index,
                    "O campo {$index} não deve ser menor que {$params[1]} caracteres"
                );
            }
        }
    }

    private static function validationCountMax(string $index, array $data, array $params)
    {
        if (count($params) !== 2) {
            throw new Exception("Parametros invalidos de validação");
        }

        if (array_key_exists($index, $data) && is_numeric($data[$index])) {
            if ($data[$index] > $params[1]) {
                self::addMessageErro(
                    $index,
                    "O campo {$index} não deve ser maior que {$params[1]}"
                );
            }
        }
    }

    private static function validationCountMin(string $index, array $data, array $params)
    {
        if (count($params) !== 2) {
            throw new Exception("Parametros invalidos de validação");
        }

        if (array_key_exists($index, $data) && is_numeric($data[$index])) {
            if ($data[$index] > $params[1]) {
                self::addMessageErro(
                    $index,
                    "O campo {$index} não deve ser menor que {$params[1]}"
                );
            }
        }
    }

    private static function addMessageErro(string $index, string $message)
    {
        if (!array_key_exists($index, self::$_messages)) {
            self::$_messages[$index] = [];
        }

        self::$_messages[$index][] = $message;
    }

    private static function getParametersValition(
        string $validation,
        string $separator = ":"
    ): array {
        $result = explode($separator, $validation);

        return $result;
    }

    public function hasError()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->messages;
    }
}
